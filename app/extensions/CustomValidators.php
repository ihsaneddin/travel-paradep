<?php namespace App\Extension\Validation;

class CustomValidator extends \Illuminate\Validation\Validator {

  public function validateHex($attribute, $value, $parameters)
  {
    if(preg_match("/^#?([a-f0-9]{6}|[a-f0-9]{3})$/", $value))
    {
      return true;
    }

    return false;
  }

  public function validateRouteDestination($attribute, $value, $parameters)
  {
    if(preg_match("/^#?([a-f0-9]{6}|[a-f0-9]{3})$/", $value))
    {
      return true;
    }

    return false;
  }

}