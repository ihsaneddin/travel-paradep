<?php

use traits\NestedAttributes;
use traits\Validator;
use interfaces\NestedAttributesInterface;
use interfaces\ValidatorInterface;
use traits\CodeAble;
use observers\BaseObserver;


class Base extends Eloquent implements NestedAttributesInterface,ValidatorInterface
{
 	use NestedAttributes;
 	use Validator;
 	use CodeAble;

 	protected $validator;
 	protected $rules = array();
 	protected $messages = array();
 	public $errors;

 	public static function boot() {
        parent::boot();
        self::observe(new BaseObserver());
    }

}