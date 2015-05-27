<?php

class Booking extends Base
{
	protected $table = 'bookings';
	protected $fillable = ['passenger_id', 'trip_id'];

	public function passenger()
    {
        return $this->belongsTo('Passenger');
    }

    public function trip()
    {
    	return $this->belongsTo('Trip');
    }

	public function rules()
	{
		$this->rules =  array('name' => 'required',
							  'code' => 'required|unique:bookings,code,'.$this->id,
							  'passenger_id' => 'required',
							  'trip_id' => 'required');
	}

}