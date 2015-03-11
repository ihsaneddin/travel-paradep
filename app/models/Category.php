<?php 

class Category extends Base
{
	public $timestamps = false;
	protected $fillable = ['name', 'for'];

	public function travelCars()
	{
		return $this->hasMany('TravelCar');
	}

	public function scopeClassListSelectInput($res)
	{
		$list = array();
		foreach ($res->where('for', 'car')->get() as $category) {
			$list = array_add($list, $category->id, ucfirst($category->name));
		}
		$list = array_add($list, '', 'Select class...');
		return $list;
	}
}