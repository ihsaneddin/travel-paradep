<?php 
namespace observers;
use Illuminate\Events\Dispatcher;

class UserObserver 
{
	protected $events;

	public function __construct(Dispatcher $dispatcher)
	{
	    $this->events = $dispatcher;
	}

	public function saving($model)
	{
		if ( is_null($model->avatar) || $model->avatar === '' )
		{
			$model->avatar = STAPLER_NULL;
		}
	}
}
