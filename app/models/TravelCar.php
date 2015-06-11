<?php
use observers\TravelCarObserver;
use traits\StationAbleModelTrait;

class TravelCar extends StatefulModel
{
	use StationAbleModelTrait;

	protected $table = 'travel_cars';
	protected $appends = array('merk','class', 'manufacture', 'stationed_id', 'last_stationed_at', 'stationed_name');
	protected $fillable = ['car_id', 'category_id', 'license_no', 'stnk_no', 'bpkb_no', 'seat'];
	protected $acceptNestedAttributes = array('photos' => ['name', 'image']);

	public static function boot() {
        parent::boot();
        self::observe(new TravelCarObserver());
    }

	public function rules()
	{
		$this->rules =  array('car_id' => 'required',
						'category_id' => 'required',
						'license_no' => 'required|alpha_num|min:7|max:9|unique:travel_cars,license_no,'.$this->id,
						'stnk_no' => 'required|alpha_num|min:10|max:20|unique:travel_cars,stnk_no,'.$this->id,
						'bpkb_no' => 'required|alpha_num|min:10|max:20|unique:travel_cars,bpkb_no,'.$this->id,
						'seat' => 'required|integer|min:10|max:20');
	}

	public function model()
	{
		return $this->belongsTo('Car', 'car_id');
	}

	public function photos()
	{
		return $this->morphMany('Attachment', 'attachable');
	}

	public function category()
	{
		return $this->belongsTo('Category');
	}

    public function addresses()
	{
		return $this->morphMany('Address', 'addressable');
	}

	public function stationeds()
    {
    	return $this->morphMany('Stationed', 'stationable');
    }

	function saveATravelCar($data)
	{
		if (array_key_exists('car_id', $data)) $data['car_id'] = $this->carModel($data['car_id'], $data['manufacture'])->id;
		if (array_key_exists('category_id', $data))  $data['category_id'] = $this->carCategory($data['category_id'])->id;
		return $this->store($data);
	}

	protected function carCategory($categoryId)
	{
		$category = Category::firstOrNew(['id' => $categoryId]);
		if ( !$category->id )
		{
			$category = Category::create(array('name' => $categoryId, 'for' => 'car'));

		}
		return $category;
	}

	protected function carModel($carId,$manufacture)
	{
		$model = Car::firstOrNew(['id' => $carId]);
		if ( !$model->id )
		{
			if ( is_null($manufacture) || empty($manufacture)) $this->attachError('manufacture', 'Manufacture is required');
			else $model = Car::create(array('name' => $carId, 'manufacture' => $manufacture));
		}
		return $model;
	}

	public function scopeListSelectInput($res, $station_id)
	{
		$list = array();
		$list = $res->lists('code', 'id');
		$list = array_add($list, '', 'Select car...');
		return $list;
	}

	public function getClassAttribute($val)
	{
		$category = $this->category()->first();
		if (!empty($category))
		{
			return $this->category()->first()->name;
		}
	}

	public function getMerkAttribute($val)
	{
		$model = $this->model()->first();
		if (!empty($model))
		{
			return $this->model()->first()->name;
		}
	}

	public function getManufactureAttribute($val)
	{
		$model = $this->model()->first();
		if (!empty($model))
		{
			return $model->manufacture;
		}
	}

	public function currentStation()
	{
		$current_station = $this->stationeds()->where('state', '=', 'active')->limit(1)->get()->first();
		if (is_null($current_station)) {return null;}
		return $current_station->station;
	}

}