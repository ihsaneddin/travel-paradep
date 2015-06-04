<?php
namespace traits;
use \App;
use exception\NestException;
use \DB;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Collection;

trait NestedAttributes
{
	protected $nestTree = array();
	protected $relationTree = array();
	protected $position=0;
	protected $_delete = 0;
	protected $operation = array('_delete');
	protected $fillable_update= array();

	//for many relationship

	public function store(array $data=array())
	{
		DB::beginTransaction();
		try{
			$save = $this->performSaveNest($data);
		}catch( NestException $exception ){
			DB::rollback();
			return false;
		}
		DB::commit();
		return true;
	}

	protected function performSaveNest(array $data = array())
	{
		$this->nestByNest($data);
		if ( ($this->errors instanceof MessageBag) ? $this->errors->any() : !is_null($this->errors) )
		{
			throw new NestException;
		}
	}

	//todo : remove root when recursing
	protected function nestByNest(array $data=array(), $parent=null, $root=null, $relation=null, $previousTree = array())
	{
		if(!empty($data))
		{
			$this->setAttributes($data, $parent, $relation);

			if ( $this->markedForDelete() )
			{
				$this->delete();
			}
			else
			{
				$this->updateRelationTree($previousTree, $relation);
				if ($this->validate()) (is_null($parent) || is_null($relation)) ? $this->save() : $parent->$relation()->save($this);
				else $this->attachErrors($root);
				if (property_exists($this, 'acceptNestedAttributes'))
				{
					foreach ($this->acceptNestedAttributes as $relation => $attributes) {
						if (array_key_exists($relation, $data))
						{
							foreach ($data[$relation] as $index => $childAttributes)
							{
								$child = $this->setChild($relation, $childAttributes);
								if ($child->id)
								$child->position = $index;
								$child->nestByNest($childAttributes, $this, is_null($root) ? $this : $root, $relation, $this->relationTree );
							}
						}
					}
				}
			}
		}
	}

	protected function setChild($relation, $data, $zero=0)
	{
		$child = App::make($this->childClass($relation))->firstOrNew([ $this->childPrimaryKey($relation) => array_get($data, $this->childPrimaryKey($relation))]);

		if ( $this->$relation instanceof Collection )
		{
			$this->$relation->push( $child);
		}
		else{
			$this->relation = $child;
		}
		return $child;
	}

	protected function attachErrors($root)
	{
		if ( !is_null($root) && !is_null($this->errors) )
		{
			$root->isMessageBag();
			$messageBag = $root->errors;
			foreach ($this->errors->toArray() as $attribute => $messages) {
				foreach ($messages as $message) {
					$messageBag->add(''.$this->positionBase().'['.$attribute.']', $message);
				}
			}
			$root->errors = $messageBag;
		}

	}

	protected function attachError($key,$message)
	{
		$this->isMessageBag();
		$messageBag = $this->errors;
		$messageBag->add($key,$message);
	}

	protected function attachErrorsParent(\Eloquent $parent,$relation)
	{
		$this->isMessageBag();
		$messageBag = $this->errors;
		if ($parent->errors instanceof MessageBag)
		{
			foreach ($parent->errors->toArray() as $attribute => $messages) {
				foreach ($messages as $message) {
					$messageBag->add(''.$relation.'['.$attribute.']', $message);
				}
			}
		}
		$this->errors = $messageBag;
	}

	protected function positionBase()
	{
		return implode('', $this->relationTree);
	}

	protected function updateRelationTree($previousTree,$relation)
	{
		empty($previousTree) ? : $this->relationTree= $previousTree;
		if ( ! is_null($relation) ) array_push($this->relationTree, $relation.'['.$this->position.']');
	}

	public function hasChilds($relation)
	{
		return !($this->$relation->isEmpty());
	}


	protected function setAttributes($data, $parent=null, $relation=null)
	{
		$allowed_attributes = $this->allowedAttributes();
		$fillable = (is_null($parent) || is_null($relation)) ? $allowed_attributes : $parent->acceptNestedAttributes[$relation];
		foreach ($data as $key => $value) {
			if (!in_array($key, $fillable) && !in_array($key, $this->operation))
			{
				 unset($data[$key]);
			}
		}
		$this->_delete = array_key_exists('_delete', $data) ? $data['_delete'] : $this->_delete;
		$this->fill($data);
	}

	protected function allowedAttributes()
	{
		$allowedAttributes = $this->fillable;
		if ($this->exists)
		{
			$allowedAttributes = empty($this->fillable_update) ? $allowedAttributes : $this->fillable_update;
		}
		return $allowedAttributes;
	}

	protected function childPrimaryKey($relation)
	{

		return App::make($this->childClass($relation))->getKeyname();
	}

	protected function childClass($relation)
	{
		return class_basename(get_class($this->$relation()->getRelated()));
	}

	protected function markedForDelete()
	{
		return $this->_delete == 1 ? true : false;
	}

}