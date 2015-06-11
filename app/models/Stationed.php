<?php

class Stationed extends StatefulModel
{
	protected $table = 'stationed_at';

	public function stationable()
    {
        return $this->morphTo();
    }

    public function station()
    {
        return $this->belongsTo('Station');
    }

    protected function stateMachineConfig()
    {
        return [
            'states' => [
                'active' => [
                    'type'       => 'initial',
                    'properties' => ['editable' => true]
                ],
                'inactive' => [
                	'type'		=> 'final',
                    'properties' => ['editable' => true]
                ]

            ],
            'transitions' => [
            	'exit' => ['from' => ['active'], 'to' => 'inactive', 'guard' => null]
            ],
            'callbacks' => [
                'after' => [
                    ['from' => 'all', 'to' => 'all', 'do' => [$this, 'saveState']]
                ]
            ]
        ];
    }

    public function rules()
    {
        return array(
                        'station_id' => 'required|numeric',
                        'stationable_id' => 'required|numeric',
                    );
    }

}