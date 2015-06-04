<?php
use observers\TripObserver;

class Trip extends Base
{
	protected $table = 'trips';
	protected $fillable = ['route_id', 'driver_id', 'travel_car_id', 'departure_date', 'departure_hour', 'arrival_date', 'arrival_hour', 'quota' ];
	protected $fillable_update = ['driver_id', 'travel_car_id', 'departure_date', 'departure_hour', 'arrival_date', 'arrival_hour' ];
	protected $appends = array('departure_time', 'arrival_time', 'quota_status');
	protected $codeable = array('code' => array('route.code','route.departure.code','route.destination.code'),
								'timestamp' => true, 'separator' => '-' );

	public static function boot() {
        parent::boot();
        self::observe(new TripObserver());
    }

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
    	return $this->belongsTo('TravelCar', 'travel_car_id');
    }

    public function bookings()
    {
    	return $this->hasMany('Booking');
    }

	public function rules()
	{
		$this->rules =  array('route_id' => 'required',
							  'driver_id' => 'numeric',
							  'travel_car_id' => 'numeric|valid_trip_car',
							  'departure_date' => 'required|date_format:"Y-m-d"',
							  'departure_hour' => 'required|time24',
							  'arrival_date' => 'required|date_format:"Y-m-d"|trip_valid_arrival_date',
							  'arrival_hour' => 'required|time24',
							  'quota' => 'required|numeric');
	}


	public function scopeFilter($res, array $filter=array())
	{
		if (!empty($filter))
		{
			$trip_code = array_get($filter,'code');
			if (!empty($trip_code))
			{
				$res->where('code', 'LIKE', '%'.$trip_code.'%');
			}
			$from_departure_date = array_get($filter, 'from_departure_date');
			$from_departure_date = format_date_time($from_departure_date, 'Y-m-d');
			if (!empty($from_departure_date))
			{
				$res->where('departure_date', '>=', $from_departure_date);
			}

			$from_departure_hour = array_get($filter, 'from_departure_hour');
			$from_departure_hour = format_date_time($from_departure_hour, 'H:i');
			if (!empty($from_departure_hour))
			{
				$res->where('departure_hour', '>=', $from_departure_hour);
			}

			$to_departure_date = array_get($filter, 'to_departure_date');
			$to_departure_date = format_date_time($to_departure_date, 'Y-m-d');
			if (!empty($to_departure_date))
			{
				$res->where('departure_date', '<=', $to_departure_date);
			}

			$to_departure_hour = array_get($filter, 'from_departure_hour');
			$to_departure_hour = format_date_time($to_departure_hour, 'H:i');
			if (!empty($to_departure_hour))
			{
				$res->where('departure_hour', '<=', $to_departure_hour);
			}

			$route_code = array_get($filter, 'route.code');
			if (!empty($route_code))
			{
				$res->where('route_id', '=', $route_code);
			}

			$driver_id = array_get($filter, 'driver.code');
			if (!empty($driver_id))
			{
				$res->where('driver_id', '=', $driver_id);
			}

			$car_id = array_get($filter, 'car.code');
			if (!empty($car_id))
			{
				$res->where('travel_car_id', '=', $car_id);
			}

			$class_id = array_get($filter, 'route.class');
			$departure_station = array_get($filter, 'route.departure');
			$destination_station = array_get($filter, 'route.destination');
			if (!empty($class_id) || !empty($departure_station) || !empty($destination_station))
			{
				$res->leftJoin('routes', function($join)
											        {
											            $join->on('routes.id', '=', 'trips.route_id');
											        });
				if ($class_id)
					$res->where('routes.category_id', '=', $class_id);
				if ($departure_station)
					$res->where('routes.departure_id', '=', $departure_station);
				if ($destination_station)
					$res->where('routes.destination_id', '=', $destination_station);
			}

		}
		return $res;
	}

	public function scopeInclude($res)
	{
		return $res->with('route', 'route.departure', 'route.destination', 'route.category', 'driver', 'car');
	}

	public function getDepartureTimeAttribute($value)
	{
		return format_date_time($this->departure_date.' '.$this->departure_hour, 'M d Y, H:i');
	}

	public function getArrivalTimeAttribute($value)
	{
		return format_date_time($this->arrival_date.' '.$this->arrival_hour, 'M d Y, H:i');
	}

	public function setDurations()
	{
		$departure_time = new DateTime($this->departure_time);
		$arrival_time = new DateTime($this->arrival_time);
		$diff = $arrival_time->diff($departure_time);
		$this->durations = $diff->format('%h Hour(s) %i Minute(s)');
	}

	public function getQuotaStatusAttribute($val)
	{
		$type = $this->quota < $this->bookings->count() ? 'danger' : 'success';
		return '<button class="btn btn-'.$type.' btn-xs" disabled="">'.$this->quota.'/'.$this->bookings->count().'</button>';
	}

}