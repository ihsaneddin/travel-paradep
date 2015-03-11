<?php

namespace traits;

use exception\ValidationException;
use validators\Validator as customValidator;
use \Schema;
use \App;
use Illuminate\Support\MessageBag;

trait Validator
{

	function rules(){}

	function validate($input=array())
	{
		$this->rules();//init rules as laravel can not properly perform unique validation
	    try {
            $validate = $this->validator()->validate( empty($input) ? $this->getAttributesArray() : $input, $this->rules, $this->messages );
 			return true;
        } catch ( ValidationException $exception ) {
            $this->isMessageBag();
            $this->errors->merge($exception->getErrors()->getMessageBag());
            return false;
        }
	}

	function isLegal()
	{
		return is_null($this->errors);
	}

	protected function validator()
	{
		if (! $this->validator instanceof customValidator)
		{

			$this->validator = new customValidator(\App::make('Illuminate\Validation\Factory'));
		}
		return $this->validator;
	}

	function getAttributesArray()
	{
		$attributes = array();
		foreach ($this->getColumns() as $column) {
			$attributes = array_add($attributes, $column, $this->$column);
		}
		return $attributes;
	}

	protected function getColumns()
	{
		return Schema::getColumnListing($this->table);
	}

	protected function isMessageBag()
	{
		if ( ! $this->errors instanceof MessageBag )
		{
			$this->errors = App::make('Illuminate\Support\MessageBag');
		}
		return true;
	}

}