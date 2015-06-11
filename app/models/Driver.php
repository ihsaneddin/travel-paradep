<?php

use traits\StationAbleModelTrait;

class Driver extends StatefulModel
{
    use StationAbleModelTrait;

	protected $table = 'drivers';
	protected $fillable = ['name', 'code'];
    protected $appends = array('stationed_id', 'last_stationed_at', 'stationed_name');

	public function trips()
    {
        return $this->hasMany('Trip');
    }

    public function stationeds()
    {
    	return $this->morphMany('Stationed', 'stationable');
    }

	public function rules()
	{
		$this->rules =  array('name' => 'required',
						'code' => 'required|unique:drivers,code,'.$this->id);
	}

	public function scopeListSelectInput($res, $station_id)
	{
        $res = empty($station_id) ? $res : $res->currentStation();
		$list = array();
		foreach ($res->avalaible()->get() as $driver) {
			$list = array_add($list, $driver->id, $driver->code);
		}
		$list = array_add($list, '', 'Select driver...');
		return $list;
	}

    public function scopeAvalaible($res)
    {
        return $res->where('drivers.state', '=', 'avalaible');
    }

}