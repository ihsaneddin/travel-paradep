<?php 
namespace traits;
use \App;
use exception\NestException;

trait NestedAttributes
{
	protected $nestTree = array();
	
	protected function updateNestree($previousTree)
	{
		empty($previousTree) ? : $this->nestTree= $previousTree;
		array_push($this->nestTree, $this);
	}

	public function store($data)
	{
		DB::beginTransaction();
		try{
			$save = $this->performSaveNest();
		}catch( NestException $exception ){
			DB::rollback();
			return false;
		}
		DB::commit();
		return true;
	}

	function performSaveNest(array $data = array())
	{
		$this->nestByNest($data);
		if ( ! is_empty($this->errors) ) 
		{
			throw new NestException;
		}
	}

	public function nestByNest(array $data=array(), $parent=null, $relation=null, $previousTree = array())
	{
		if(!empty($data))
		{
			$this->updateNestree($previousTree);
			if ( ! is_null(parent)) $this->setAttributes($data);
			if ( $this->isValid() )
			{
				is_null($parent) || is_null($relation) ? $this->save() : $parent->$relation()->save($this);
			}
			else $this->attachErrorMessage();
			
			if (property_exists($this, 'acceptNestedAttributes'))
			{
				foreach ($this->acceptNestedAttributes as $relation => $attributes) {
					if (array_key_exists($relation, $data))
					{
						foreach ($data[$relation] as $id => $childAttributes) 
						{
							$child = $this->setChildObject($relation,$id);
							$child->nestByNest($childAttributes, $this, $relation, $this->nestTree );
						}
					}
				}
			}

		}
	}

	function root()
	{
		return  is_empty($this->nestTree) ? $this : first_array($this->nestTree);
	}

	function attachErrorMessage()
	{
		$messageBag = $this->root()->errors;
        if (! $messageBag instanceof MessageBag) {
            $messageBag = App::make('Illuminate\Support\MessageBag');
        }

        $messageBag->add('avatar', $this->errors );
        $this->root()->errors = $messageBag;
	}

	public function nestSave($data)
	{
		$this->fill($this->setAttributes($data));
	    if ($this->save())
	    {
	    	foreach ($nestedAttributes as $relation => $attributes) {
	    		if (array_key_exists('id', $attributes))
	    		{
	    			$child = $this->setRelationObject($relation, $attributes);
	    			$child->nestSave();
	    		}
	    	}
	    }
	    return true;
	}

	function setAttributes($data)
	{
		foreach ($data as $key => $value) {
			if (!in_array($key, $this->fillable))
			{
				 unset($data[$key]);
			}
		}
		$this->fill($data);
	}

	function setChildObject($relation, $id, $zero=0)
	{ 
		return App::make($this->childClass($relation))->firstOrNew([ $this->childPrimaryKey($relation) => $id]);
	}

	function childPrimaryKey($relation)
	{
		
		return App::make($this->childClass($relation))->getKeyname();	
	}

	function childClass($relation)
	{
		return class_basename(get_class($this->$relation()->getRelated()));
	}

}