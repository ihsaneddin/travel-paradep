<?php
use traits\FiniteStateMachineTrait;

class StatefulModel extends Base implements Finite\StatefulInterface
{
	use FiniteStateMachineTrait;

    public function newFromBuilder($attributes = [])
	{
	    $instance = parent::newFromBuilder($attributes);
	    $instance->getStateMachine()->initialize();
	    return $instance;
	}

	public static function boot()
	{
		parent::boot();
		self::creating(function($model){

	         $model->setInitialState();
	         return true;
	     });
	}

	protected function stateMachineConfig()
    {
    	return array();
    }

    public function saveState($myStatefulInstance, $transitionEvent)
    {
    	$this->push();
    }


}