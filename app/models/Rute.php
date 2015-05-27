<?php

class Rute extends Base
{
	protected $fillable = ['name', 'code', 'price', 'category_id', 'departure', 'destination'];
	protected $table = 'routes';
	protected $appends= array('destination_station', 'departure_station');

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
							  'departure' => 'required|different:destination',
							  'destination' => 'required|different:departure',
							  'category_id' => 'required');
	}

	public function getDestinationStationAttribute($val)
	{
		try{
			return $this->destination()->first()->name.' '.$this->destination()->first()->addresses->first()->city;
		}catch(Exception $e)
		{
			return null;
		}
	}

	public function getDepartureStationAttribute($val)
	{
		try {
			return ''.$this->departure()->first()->name.' '.$this->departure()->first()->addresses->first()->city;
		}
		catch(Exception $e)
		{
			return null;
		}

	}


	public function scopeListSelectInput($res)
	{
		$list = array();
		foreach ($res->get() as $route) {
			$list = array_add($list, $route->id, $route->code);
		}
		$list = array_add($list, '', 'Select route...');
		return $list;
	}





}