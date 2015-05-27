<?php

class Passenger extends Base
{
	protected $table = 'passengers';
	protected $fillable = ['name', 'phone'];

	public function bookings()
    {
        return $this->hasMany('Booking');
    }

	public function rules()
	{
		$this->rules =  array('name' => 'required',
							  'phone' => 'required|numeric|unique:passengers,phone,'.$this->id);
	}

}