<?php namespace extensions\validation;
use \DateTime;

class CustomValidator extends \Illuminate\Validation\Validator {

	protected $customValidatorMessages = array();

  public function validateAfterTime($attribute, $value, $parameters)
  {
   	$date_before = DateTime::createFromFormat('Y-m-d H:i:s', array_get($this->data, $parameters[0]));
   	$date_now = DateTime::createFromFormat('Y-m-d H:i:s', $value);
   	if ($date_now && $date_before)
   	{
   		if ($date_before < $date_now)
   		{
   			return true;
   		}
   	}
   	$message = 'The '.$attribute.' must be less than field '.$parameters[0].'.';
	$this->getMessageBag()->add($attribute, $message);
   	return false;
  }

}

\Validator::resolver(function($translator, $data, $rules, $message){
 return new CustomValidator($translator, $data, $rules, $message);
});