<?php 

class TravelCar extends Base
{
	protected $table = 'travel_cars';
	protected $fillable = ['car_id', 'category_id', 'license_no', 'stnk_no', 'bpkb_no', 'seat'];
	protected $acceptNestedAttributes = array('photos' => ['name', 'image']);
	
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

}