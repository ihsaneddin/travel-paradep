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

	//for many relationship
	public function build($relation)
	{
		$child = App::make($this->childClass($relation));
		if  ( $this->$relation instanceof Collection)
		{
			$this->$relation->push($child);
		}
	}

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
			$this->updateRelationTree($previousTree, $relation);
			$this->setAttributes($data, $parent, $relation);
			if ($this->validate()) (is_null($parent) || is_null($relation)) ? $this->save() : $parent->$relation()->save($this);			
			else $this->attachErrors($root);
			if (property_exists($this, 'acceptNestedAttributes'))
			{
				foreach ($this->acceptNestedAttributes as $relation => $attributes) {
					if (array_key_exists($relation, $data))
					{
						foreach ($data[$relation] as $index => $childAttributes) 
						{
							$child = $this->setChild($relation, $attributes);
							$child->position = $index;	
							$child->nestByNest($childAttributes, $this, is_null($root) ? $this : $root, $relation, $this->relationTree );
						}
					}
				}
			}

		}
	}

	protected function setChild($relation, $id, $zero=0)
	{ 
		$child = App::make($this->childClass($relation))->firstOrNew([ $this->childPrimaryKey($relation) => $id]);
		
		if ( $this->$relation instanceof Collection )
		{
			$this->$relation->push( $child);
		}
		else{
			$this->relations[$relation] = $child;
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
				$root->errors = $messageBag;
			}
		}

	}

	protected function attachError($key,$message)
	{
		$this->isMessageBag();
		$messageBag = $this->errors;
		$messageBag->add($key,$message);
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


	protected function setAttributes($data, $parent, $relation=null)
	{
		$fillable = (is_null($parent) || is_null($relation)) ? $this->fillable : $parent->acceptNestedAttributes[$relation];
		foreach ($data as $key => $value) {
			if (!in_array($key, $fillable))
			{
				 unset($data[$key]);
			}
		}
		$this->fill($data); 
	}

	protected function childPrimaryKey($relation)
	{
		
		return App::make($this->childClass($relation))->getKeyname();	
	}

	protected function childClass($relation)
	{
		return class_basename(get_class($this->$relation()->getRelated()));
	}

}