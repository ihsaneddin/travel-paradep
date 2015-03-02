<?php 
namespace exception;

use Exception;
use Illuminate\Support\MessageBag;

abstract class BaseException extends Exception
{
	protected $errors;

	function __construct( $errors = null, $messages= null, $code = 0, Exception $previous = null)
	{ 
		$this->_setErrors( $errors );
		parent::__construct( $messages, $code, $previous );
	}

	protected function _setErrors( $errors )
	{
		if ( is_string($errors) )
		{
			$errors = [ 'error' => $errors ];
		}
		if ( is_array($errors) )
		{
			$errors = new MessageBag( $errors );
		}
		$this->errors = $errors;
	}
	public function getErrors()
	{
		return $this->errors;
	}
}