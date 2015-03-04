<?php 
namespace traits;
use \App;
use exception\NestException;
use \DB;
use Illuminate\Support\MessageBag;

trait NestedAttributes
{
	protected $nestTree = array();
	protected $relationTree = array();
	protected $position=0;

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
		if ( $this->errors->any() ) 
		{
			throw new NestException;
		}
	}

	protected function nestByNest(array $data=array(), $parent=null, $root=null, $relation=null, $previousTree = array())
	{
		if(!empty($data))
		{
			$this->updateRelationTree($previousTree, $relation);
			$this->setAttributes($data, $parent, $relation);
			if ( $this->validate() )
			{
				is_null($parent) || is_null($relation) ? $this->save() : $parent->$relation()->save($this);
			}
			else $this->attachErrors($root);
			if (property_exists($this, 'acceptNestedAttributes'))
			{
				foreach ($this->acceptNestedAttributes as $relation => $attributes) {
					if (array_key_exists($relation, $data))
					{
						foreach ($data[$relation] as $index => $childAttributes) 
						{
							$child = $this->setChildObject($relation, $attributes);
							$child->position = $index;
							$this->addChild($relation, $child);
							$child->nestByNest($childAttributes, $this, is_null($root) ? $this : $root, $relation, $this->relationTree );
						}
					}
				}
			}

		}
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

	protected function positionBase()
	{
		return implode('', $this->relationTree); 
	}

	protected function updateRelationTree($previousTree,$relation)
	{
		empty($previousTree) ? : $this->relationTree= $previousTree;
		if ( ! is_null($relation) ) array_push($this->relationTree, $relation.'['.$this->position.']');
	}

	public function hasChilds()
	{
		return !empty($this->childs);
	}

	protected function isMessageBag()
	{
		if ( ! $this->errors instanceof MessageBag )
		{
			$this->errors = App::make('Illuminate\Support\MessageBag');
		}
		return true;
	}

	protected function addChild($relation, $child)
	{
		if ( ! array_key_exists($relation, $this->childs) )
		{
			$this->childs[$relation] = array();				
		}
		$this->childs[$relation] = array_add($this->childs[$relation], $child->position, $child); 
	}

	protected function setAttributes($data, $parent, $relation=null)
	{
		$fillable = is_null($relation) && property_exists(is_null($parent) ? $this : $parent, 'acceptNestedAttributes') ? $this->fillable : $parent->acceptNestedAttributes[$relation]; 
		foreach ($data as $key => $value) {
			if (!in_array($key, $fillable))
			{
				 unset($data[$key]);
			}
		}
		$this->fill($data); 
	}


	protected function setChildObject($relation, $id, $zero=0)
	{ 
		return App::make($this->childClass($relation))->firstOrNew([ $this->childPrimaryKey($relation) => $id]);
	}

	protected function childPrimaryKey($relation)
	{
		
		return App::make($this->childClass($relation))->getKeyname();	
	}

	protected function childClass($relation)
	{
		return class_basename(get_class($this->$relation()->getRelated()));
	}

	//used for attaching childs errors to root
	protected function attachErrorsChilds($root = null)
	{
		if ( $this->hasChilds() )
		{
			$root = is_null($root) ? $this : $root;
			$messageBag = $root->errors;
			foreach ($this->childs as $relation => $childs) {
				foreach ($childs as $index => $child) {
					if ( !is_null($child->errors) )
					{
						foreach ($child->errors->toArray() as $attribute => $messages) {
							$child->attachErrors($root);
							foreach ($messages as $message) {
								$messageBag->add(''.$child->positionBase().''.$attribute.'', $message);	
							}
							$root->errors = $messageBag;
						}
					}
				}
			}
		}
	}

}