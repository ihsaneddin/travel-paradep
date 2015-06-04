<?php
use Illuminate\Support\MessageBag;

class Booking extends Base
{
	protected $table = 'bookings';
	protected $fillable = ['passenger_id', 'trip_id', 'seat_no'];
	protected $codeable = array('code' => array('trip.code','passenger.id'),
								'timestamp' => false, 'separator' => '-' );
	protected $appends = array('payment_status');

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
		$this->rules =  array('seat_no' => 'required|numeric|not_in:'.implode(',', $this->usedSeatNo()),
							  'passenger_id' => 'required|numeric',
							  'trip_id' => 'required|numeric');
	}

	public function scopeFilter($res, $filter = array())
	{
		if (!empty($filter))
		{
			$code = array_get($filter, 'code');
			if (!empty($code))
			{
				$res->where('code', 'like', '%'.$code.'%');
			}

			$trip_code = array_get($filter, 'trip.code');
			if (!empty($trip_code))
			{
				$res->leftJoin('trips', function($join)
											        {
											            $join->on('trips.id', '=', 'bookings.trip_id');
											        })->where('trips.code', 'like', '%'.$trip_code.'%');
			}

			$passenger_name = array_get($filter, 'passenger.name');
			$passenger_phone = array_get($filter, 'passenger.phone');
			if(!empty($passenger_name)||!empty($passenger_phone))
			{
				$res->leftJoin('passengers', function($join){
					$join->on('passengers.id', '=', 'bookings.passenger_id');
				});
				if ($passenger_name)
					$res->where('passengers.name', 'like', '%'.$passenger_name.'%');
				if ($passenger_phone)
					$res->where('passengers.phone', '=', '%'.$passenger_phone.'%');
			}
		}
		return $res;
	}

	public function save_a_booking($params, $flag=false)
	{
		DB::beginTransaction();
		try{
			$passenger = Passenger::firstOrNew(array('phone' => array_get($params, 'passenger.phone')));
			$passenger->store(array_get($params, 'passenger'));
			$this->passenger()->associate($passenger);
			if ($this->store($params))
			{
				if (empty($passenger->errors))
				{
					DB::commit();
					return true;
				}
			}
			$this->attachErrorsParent($passenger,'passenger');
			DB::rollback();
		}catch( Exception $exception ){
			DB::rollback();
			return false;
		}
		return false;
	}

	public function usedSeatNo($used_seat = array())
	{
		if (!empty($this->trip))
		{
			$used_seat =  $this->trip->bookings->lists('seat_no');

		}
		return $used_seat;
	}

	public function avalaibleSeatsNo()
	{
		$avalaibleSeats = array();
		$quota = $this->trip->quota;
		$usedSeats = $this->usedSeatNo();
		for ($i=1; $i <= $quota ; $i++) {
			if (!in_array($i, $usedSeats))
			{
				$avalaibleSeats[$i] = $i;
			}
		}
		$avalaibleSeats = array_add($avalaibleSeats, '', 'Select seat number');
		return $avalaibleSeats;
	}

	public function getPaymentStatusAttribute($val)
	{
		$type = $this->paid ? 'success' : 'danger' ;
		$status = $this->paid ? "complete" : "not yet paid";
		return '<button class="btn btn-'.$type.' btn-xs" disabled="">'.$status.'</button>';
	}

}