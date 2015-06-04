<?php
namespace observers;
use Illuminate\Events\Dispatcher;

class TripObserver extends AbstractObserver
{
	protected $events;

	public function saving($trip)
	{
		$trip->setDurations(); #set interval between
	}
}
