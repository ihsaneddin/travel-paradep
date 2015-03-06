<?php

use traits\NestedAttributes;
use traits\Validator;
use interfaces\NestedAttributesInterface;
use interfaces\ValidatorInterface;


class Base extends Eloquent implements NestedAttributesInterface,ValidatorInterface
{
 	use NestedAttributes;
 	use Validator;
 	protected $validator;
 	protected $rules = array();
 	protected $messages = array();

 	public function __construct(array $attributes =array())
	{
		$this->isMessageBag();
		parent::__construct($attributes);
	}

 	public static function boot()
 	{
 		parent::boot();
 		static::saving(function($model)
 		{
 			return $model->validate();
 		});
 	}
}