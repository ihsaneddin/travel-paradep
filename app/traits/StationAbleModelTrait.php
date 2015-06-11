<?php
namespace traits;

use \DB;
use \Stationed;
use \Station;

trait StationAbleModelTrait {

	public function stationeds()
    {
    	return $this->morphMany('Stationed', 'stationable');
    }

    protected function stateMachineConfig()
    {
        return [
            'states' => [
                'avalaible' => [
                    'type'       => 'initial',
                    'properties' => ['editable' => true]
                ],
                'not avalaible' => [
                	'type'		=> 'normal',
                	'properties' => ['editable' => true]
                ]

            ],
            'transitions' => [
            	'on trip' => ['from' => ['avalaible'], 'to' => 'not avalaible', 'guard' => null ],
            	'off trip' => ['from' => ['not avalaible'], 'to' => 'avalaible', 'guard' => null]
            ],
            'callbacks' => [
                'before' => [],
                'after' => [
                	['on' => 'on trip', 'do' => [$this, 'afterOnTripTransition']],
                	['on' => 'off trip', 'do' => [$this, 'afterOffTripTransition']],
                    ['from' => 'all', 'to' => 'all', 'do' => [$this, 'saveState']]
                ]
            ],
        ];
    }

    public function afterOntripTransition()
    {
    	if ($this->currentStationable())
    	{
    		$this->currentStationable()->apply('exit');
    	}
    }

    public function afterOffTripTransition()
    {}

    public function update_station($station_id)
	{
		$station = Station::find($station_id);
		$message = is_null($station) ?  'Station is not found' :'An error has ocurred!';
		if (!is_null($station))
		{
			DB::beginTransaction();
			try{
				$stationed = new Stationed;
				$stationed->stationable()->associate($this);
				$stationed->station()->associate($station);
				$last_stationed_at = $this->last_stationed_at;
				if (!is_null($last_stationed_at))
				{
					if ($last_stationed_at->station_id == $stationed->station_id)
					{
						return true;
					}
					if ($last_stationed_at->isInitial())
					{
						if (!$last_stationed_at->apply('exit'))
						{
							DB::rollback();
							$message = 'Error when changing state';
							$this->attachError('station_id', $message);
							return false;
						}
					}
				}
				if ($stationed->push())
				{
					DB::commit();
					return true;
				}

			}catch(\Exception $e)
			{
				$this->attachError('station' ,$e->getMessage());
				DB::rollback();
			}

		}
		$this->attachError('station_id', $message);
		return false;
	}

    public function getStationedIdAttribute($value)
	{
		if (is_null($this->last_stationed_at))
		{
			return null;
		}
		return $this->last_stationed_at->station_id;
	}

	public function getLastStationedAtAttribute($value)
	{
		return $this->stationeds()->where('state', '=', 'active')->get()->last();
	}

	public function getStationedNameAttribute($value)
	{
		if (is_null($this->last_stationed_at))
		{
			return null;
		}
		return $this->last_stationed_at->station->name.' '.$this->last_stationed_at->station->address;
	}

    public function scopeCurrentStation($res, $station_id)
    {
        if (!empty($station_id))
        {
            $res->join('stationed_at', function($join){
                $join->on('drivers.id', '=', 'stationed_at.stationable_id')->where('stationed_at.stationable_type', '=', 'Driver')
                ->where('stationed_at.state', '=', 'active')
                ->where('stationed_at.station_id', '=', $station_id);
            });
        }
        return $res;
    }

    public function currentStationable()
    {
        $current_station = $this->stationeds()->where('state', '=', 'active')->limit(1)->get()->first();
        if (is_null($current_station)) {return null;}
        return $current_station->station;
    }

    public function currentStation()
    {
    	return is_null($this->currentStationable()) ? null : $this->currentStationable()->station;
    }

    public function isAvalaibleOn($station_id)
    {
        return is_null($this->currentStation()) ? false : ($this->currentStation()->id == $station_id);
    }

}