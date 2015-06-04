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

  public function validateTime24($attribute, $value, $parameters)
  {
    if (preg_match('/(2[0-3]|[0-1]?[0-9]):[0-5]?[0-9](:[0-5]?[0-9])?/', $value))
    {
      return true;
    }
    $message = 'The '.$attribute.' must contain hour format "HH:mm" ';
    $this->getMessageBag()->add($attribute, $message);
    return false;
  }

  public function validateTripValidArrivalDate($attribute, $value, $parameters)
  {
    $departure_time =  DateTime::createFromFormat('Y-m-d H:i', array_get($this->data, 'departure_date').' '.array_get($this->data, 'departure_hour'));
    if ($departure_time == false)
    {
      $departure_time =  DateTime::createFromFormat('Y-m-d H:i:s', array_get($this->data, 'departure_date').' '.array_get($this->data, 'departure_hour'));
    }
    $arrival_time = DateTime::createFromFormat('Y-m-d H:i', array_get($this->data, 'arrival_date').' '.array_get($this->data, 'arrival_hour'));
    if ($arrival_time == false)
    {
      $arrival_time = DateTime::createFromFormat('Y-m-d H:i:s', array_get($this->data, 'arrival_date').' '.array_get($this->data, 'arrival_hour'));
    }

    if ($departure_time && $arrival_time)
    {
      if ($arrival_time > $departure_time)
      {
        return true;
      }
    }
    $message = 'The '.$attribute.' must be greater than departure time. ';
    $this->getMessageBag()->add($attribute, $message);
    return false;
  }

  public function validateValidTripCar($attribute, $value, $parameters)
  {
    $car = \TravelCar::find(array_get($this->data, 'travel_car_id'));
    if (!empty($car))
    {
      if ($car->seat != array_get($this->data, 'quota'))
      {
        $message = 'Car\'s seat and trip quota must be equal';
        $this->getMessageBag()->add($attribute, $message);
        return false;
      }
    }
    return true;
  }

}

\Validator::resolver(function($translator, $data, $rules, $message){
 return new CustomValidator($translator, $data, $rules, $message);
});