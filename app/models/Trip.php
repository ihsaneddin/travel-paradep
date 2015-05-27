<?php

class Trip extends Base
{
	protected $table = 'trips';
	protected $fillable = ['route_id', 'driver_id', 'travel_car_id', 'departure_time', 'arrival_time' ];

	public function route()
    {
        return $this->belongsTo('Rute');
    }

    public function driver()
    {
    	return $this->belongsTo('Driver');
    }

    public function car()
    {
    	return $this->belongsTo('TravelCar');
    }

    public function bookings()
    {
    	return $this->hasMany('Booking');
    }

	public function rules()
	{
		$this->rules =  array('route_id' => 'required',
							  'driver_id' => 'required',
							  'travel_car_id' => 'required',
							  'departure_time' => 'required',
							  'arrival_time' => 'required|after_time:departure_time');
	}


	public function scopeFilter($res, $filter=array())
	{
		if (!empty($filter))
		{

		}
		return $res;
	}

	public function save_a_trip($trip_data = array())
	{

	}

}