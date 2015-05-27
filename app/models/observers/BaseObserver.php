<?php
namespace observers;
use Illuminate\Events\Dispatcher;

class BaseObserver extends AbstractObserver
{
	protected $events;

	public function creating($model)
	{
		$model->set_code();
	}
}
