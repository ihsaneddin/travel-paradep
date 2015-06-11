<?php
use observers\TripObserver;

class Trip extends StatefulModel
{

	protected $table = 'trips';
	protected $fillable = ['route_id', 'driver_id', 'travel_car_id', 'departure_date', 'departure_hour', 'arrival_date', 'arrival_hour', 'quota' ];
	protected $fillable_update = ['driver_id', 'travel_car_id', 'departure_date', 'departure_hour', 'arrival_date', 'arrival_hour','quota' ];
	protected $appends = array('departure_time', 'arrival_time', 'durations', 'quota_status', 'avalaible_quota', 'pretty_state', 'pretty_class');
	protected $codeable = array('code' => array('route.code','route.departure.code','route.destination.code'),
								'timestamp' => true, 'separator' => '-' );

    public static function boot() {
        parent::boot();
        self::observe(new TripObserver());
    }

    protected function stateMachineConfig()
    {
        return [
            'states' => [
                'waiting' => [
                    'type'       => 'initial',
                    'properties' => ['editable' => true]
                ],
                'ready' => [
                    'type'       => 'normal',
                    'properties' => []
                ],
                'on trip' => [
                    'type'        => 'normal',
                    'properties'  => []
                ],
                'delayed' => [
                	'type' => 'normal',
                	'properties' => ['editable' => true]
                ],
                'arrived' => [
                	'type' => 'final',
                	'properties' => ['complete' => true]
                ],
                'canceled' => [
                	'type' => 'final',
                	'properties' => [],
                ],

            ],
            'transitions' => [
                'set ready'  => ['from' => ['waiting', 'delayed'], 'to' => 'ready', 'guard' => array($this, 'guardValidReadyState')],
                'delay' => ['from' => ['waiting'], 'to' => 'delayed', 'guard' => null ],
                'depart'  => ['from' => ['ready'], 'to' => 'on trip', 'guard' => null],
                'arrive'  => ['from' => ['on trip'], 'to' => 'arrived', 'guard' => null],
                'cancel' => ['from' => ['waiting', 'ready', 'delayed'], 'to' => 'canceled', 'guard' => null]
            ],
            'callbacks' => [
                'before' => [
                    ['on' => 'set ready', 'do' => [$this, 'beforeReadyTransition']],
                    ['on' => 'arrive', 'do' => [$this, 'beforeArriveTransition']]
                ],
                'after' => [
                    ['on' => 'set ready', 'do' => [$this, 'afterReadyTransition']],
                    ['on' => 'arrive', 'do' => [$this, 'afterArriveTransition']],
                    ['on' => 'delay', 'do' => [$this, 'afterDelayTransition']],
                    ['from' => 'all', 'to' => 'all', 'do' => [$this, 'saveState']]
                ],
            ],
        ];
    }

    public function guardValidReadyState()
    {
    	$guard = true;
    	if ($this->bookings()->active()->isEmpty())
    	{
    		$guard = false;
    		$this->attachError('state', 'Bookings can not empty');
    	}
    	if (!$this->bookings()->where('paid', '=', false)->get()->isEmpty())
    	{
    		$guard = false;
    		$this->attachError('state', 'There is one or more unpaid booking(s).');
    	}
    	if (is_null($this->car))
    	{
    		$guard = false;
    		$this->attachError('state', 'Travel car has been not set.');
    	}

    	if (is_null($this->driver))
    	{
    		$guard = false;
    		$this->attachError('state', 'Driver has not been set.');
    	}

    	if ($this->car)
    	{
    		if (!is_null($this->car->currentStation()) && (!$this->car->isAvalaibleOn($this->route->departure_id)) )
    		{
    			$guard = false;
    			$this->attachError('state', 'Registered travel car is not avalaible in this station now');
    		}
    	}

    	if ($this->driver)
    	{
    		if (is_null($this->driver->currentStation()) || (!$this->driver->isAvalaibleOn($this->route->departure_id)))
    		{
    			$guard = false;
    			$this->attachError('state', 'Registered driver is not avalaible in this station now');
    		}
    	}
    	if ($this->car)
    	{
    		if (is_null($this->car->currentStation()) || (!$this->car->isAvalaibleOn($this->route->departure_id)))
    		{
    			$guard = false;
    			$this->attachError('state', 'Registered car is not avalaible in this station now');
    		}
    	}

    	return $guard;
    }

    public function beforeReadyTransition($myStatefulInstance, $transitionEvent)
    {

    }

    public function beforeArriveTransition($myStatefulInstance, $transitionEvent)
    {
    	$this->setArrivalTime();
    }

    public function afterReadyTransition($myStatefulInstance, $transitionEvent)
    {
    	$this->car->apply('on trip');
    	$this->driver->apply('on trip');
    }

    public function afterDelayTransition($myStatefulInstance, $transitionEvent)
    {

    }

    public function afterArriveTransition($myStatefulInstance, $transitionEvent)
    {
    	$this->car->update_station($this->route->destination->id);
    	$this->car->apply('off trip');
    	$this->driver->update_station($this->route->destination->id);
    	$this->car->apply('off trip');
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
							  'departure_date' => 'required|date_format:"Y-m-d"|trip_valid_departure_date:'.$this->getOriginal('departure_date').' '.$this->getOriginal('departure_hour'),
							  'departure_hour' => 'required|time24',
							  'quota' => 'required|numeric|min:'.array_get($this->original, 'quota') );
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
		if ($this->hasProperty('complete')){return format_date_time($this->arrival_date.' '.$this->arrival_hour, 'M d Y, H:i');}
		return null;
	}

	public function getDurationsAttribute($val)
	{
		if ($this->hasProperty('complete'))
		{
			$departure_time = new DateTime($this->departure_time);
			$arrival_time = new DateTime($this->arrival_time);
			$diff = $arrival_time->diff($departure_time);
			return $diff->format('%h:%i:%s');
		}
		return $this->route->duration;
	}

	public function getQuotaStatusAttribute($val)
	{
		$type = $this->quota < $this->bookings()->active()->count() ? 'danger' : 'success';
		return '<button class="btn btn-'.$type.' btn-xs" disabled="">'.$this->quota.'/'.$this->bookings->count().'</button>';
	}

	public function getAvalaibleQuotaAttribute()
	{
		return $this->quota - $this->bookings()->active()->count();
	}

	public function getPrettyStateAttribute($val)
	{
		$type = 'primary';
		switch ($this->getState()) {
			case 'delayed':
				$type = 'warning';
				break;
			case 'ready':
				$type = 'primary';
				break;
			case 'on trip':
				$type = 'info';
				break;
			case 'arrived':
				$type = "success";
				break;
			case 'canceled':
				$type = "danger";
				break;
		}
		return '<button class="btn btn-'.$type.' btn-xs" disabled="">'.ucwords($this->getState()).'</button>';
	}

	public function getPrettyClassAttribute($val)
	{
		return "<span class='btn btn-xs btn-warning' disabled=''> ".ucwords($this->route->category->name)."</span>";
	}

	public function setArrivalTime()
	{
		if ($this->hasProperty('complete'))
		{
				$departure_time = carbon_format('M d Y, H:i', $this->departure_time);
				$now = carbon_format();
				$arrival_time = $departure_time->addMinutes($departure_time->diffInMinutes($now));
				$this->arrival_date = format_date_time($arrival_time->toDateTimeString(), 'Y-m-d');
				$this->arrival_time = format_date_time($arrival_time->toDateTimeString(), 'H:i:s');
		}
	}

}