<?php

class Rute extends Base
{
	protected $fillable = ['name', 'code', 'price', 'category_id', 'departure_id', 'destination_id'];
	protected $table = 'routes';
	protected $appends= array('destination_station', 'departure_station');

	public function departure()
	{
		return $this->belongsTo('Station', 'departure_id');
	}

	public function destination()
	{
		return $this->belongsTo('Station', 'destination_id');
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
							  'departure_id' => 'required|different:destination_id',
							  'destination_id' => 'required',
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