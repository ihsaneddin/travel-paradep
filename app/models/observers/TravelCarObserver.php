<?php 
namespace observers;
use Illuminate\Events\Dispatcher;

class TravelCarObserver extends AbstractObserver
{
	protected $events;

	public function created($car)
	{
		$car->code = $car->id.''.$car->car_id.''.$car->category_id.'-'.$car->model->name;
		$car->save();	
	}

	public function saved($model)
    {
        //$this->clearCacheSections($model->getTable());
    }
    
    public function deleted($model) {
        //$this->clearCacheSections($model->getTable());
    }
}
