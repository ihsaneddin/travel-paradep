<?php

class Station extends Base
{
	protected $fillable = ['name', 'code'];
	protected $table = 'stations';
	protected $acceptNestedAttributes = array('addresses' => ['name', 'city', 'state']);
	protected $appends = ['address'];

	public function addresses()
	{
		return $this->morphMany('Address', 'addressable');
	}

	public function routes()
	{
		return $this->hasMany('Rute', 'departure_id');
	}

	public function rules()
	{
		$this->rules =  array('name' => 'required|unique:stations,name,'.$this->id,
							  'code' => 'required|unique:stations,code,'.$this->id);
	}

	public function getAddressAttribute($value)
	{
		$address = $this->addresses->first();
		return $address->name.', '.$address->city.', '.$address->state;
	}

	function scopeStationListSelectOptions($query)
	{
		$list=array();
		$cities = Address::groupBy('city')->lists('city');
		foreach ($cities as $city) {
			$stations = self::leftJoin('addresses', function($join)
											        {
											            $join->on('stations.id', '=', 'addresses.addressable_id')
											                 ->where('addresses.addressable_type', '=', get_class($this));
											        })
					->where('addresses.city', '=', $city)->select('stations.id', 'stations.name')->get();
			$list = array_add($list,$city, $stations->lists('name','id'));
		}
		$list =array_add($list, '', 'Select station');
		return $list;
	}


}