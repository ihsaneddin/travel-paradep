<?php

class Schedule extends Base
{
	protected $table = 'schedules';
	protected $fillable = ['hour', 'weekend', 'route_id'];

	public function route()
    {
        return $this->belongsTo('Rute');
    }

	public function rules()
	{
		$this->rules =  array('hour' => 'required|Time24',
						'weekend' => 'in:0,1',
						'route_id' => 'required');
	}

	public function scopeFilter($res, $filter)
	{
		return $res->included();
	}

	public function scopeIncluded($res)
	{
		return $res->with('route', 'route.category');
	}

	public function save_a_schedule($params)
	{
		DB::beginTransaction();
			$route_id = array_get($params, 'station_id');
			if (!empty($route_id))
			{
				$route = Rute::find($route_id);
				if (is_null($route))
				{
					$this->attachError('route_id', 'No route with such id');
				}
			}
			$this->store($params);
			if (is_null($this->errors))
			{
				DB::commit();
				return true;
			}

		DB::rollback();
		return false;
	}

}