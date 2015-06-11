<?php
namespace observers;
use Illuminate\Events\Dispatcher;

class TripObserver extends AbstractObserver
{
	protected $events;

	public function updating($trip)
	{
		$old_departure_time = format_date_time($trip->getOriginal('departure_date').' '.$trip->getOriginal('departure_hour'), 'M d Y, H:i');
		$new_departure_time = format_date_time($trip->departure_date.' '.$trip->departure_hour, 'M d Y, H:i');
		if ($new_departure_time > $old_departure_time)
		{
			if ($trip->isInitial()){
				$trip->setFiniteState('delayed');
			}
		}
	}
}
