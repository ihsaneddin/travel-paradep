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
 	public $errors;

 	public function __construct(array $attributes =array())
	{
		parent::__construct($attributes);
	}

}