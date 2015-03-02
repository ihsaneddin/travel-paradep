<?php

namespace traits;

use exception\ValidationException;
use validators\Validator as customValidator;
use \Schema;

trait Validator
{
	function isValid()
	{
		return $this->validate();
	}

	function validate()
	{
		try {
            $validate = $this->validator()->validate( $this->getAttributesArray(), $this->rules, $this->messages );
 			return true;
        } catch ( ValidationException $exception ) {
            $this->errors = $exception->getErrors();
            return false;
        }
	}

	function validator()
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