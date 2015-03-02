<?php

use traits\NestedAttributes;
use traits\Validator;
use interfaces\NestedAttributesInterface;
use interfaces\ValidatorInterface;
use Illuminate\Validation\Factory as IlluminateValidator;

class Base extends Eloquent implements NestedAttributesInterface,ValidatorInterface
{
 	use NestedAttributes;
 	use Validator;

 	protected $validator;
 	protected $rules;
 	protected $messages;

}