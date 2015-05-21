<?php

class Rute extends Base
{
	protected $fillable = ['name', 'code', 'price', 'category_id', 'departure', 'destination'];
	protected $table = 'routes';
	protected $appends= array('destination_stations', 'departure_station');

	public function departure()
	{
		return $this->belongsTo('Station', 'departure');
	}

	public function destination()
	{
		return $this->belongsTo('Station', 'destination');
	}

	public function category()
	{
		return $this->belongsTo('Category');
	}

	public function rules()
	{
		$this->rules =  array('name' => 'required',
							  'code' => 'required|unique:routes,code,'.$this->id,
							  'price' => 'required|numeric',
							  'departure' => 'required',
							  'destination' => 'required',
							  'category_id' => 'required');
	}

	public function getDestinationStationAttribute($val)
	{
		return $this->destination()->first()->name.' '.$this->destination()->first()->addresses->first()->city;
	}

	public function getDepartureStationAttribute($val)
	{
		return ''.$this->departure()->first()->name.' '.$this->departure()->first()->addresses->first()->city;
	}




}