<?php

namespace traits;

use exception\ValidationException;
use validators\Validator as customValidator;
use \Schema;

trait Validator
{

	function validate($input=array())
	{
		try {
            $validate = $this->validator()->validate( empty($input) ? $this->getAttributesArray() : $input, $this->rules, $this->messages );
 			return true;
        } catch ( ValidationException $exception ) {
            $this->errors = $exception->getErrors();
            return false;
        }
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

}