<?php 

class Car extends Base
{
	public $timestamps = false; 
	protected $fillable = ['name', 'manufacture'];
	protected $rules = ['name' => array( 'required')];
	protected $messages =array();

	function travelCars()
	{
		$this->hasMany('TravelCar');
	}

	function scopeCarListSelectOptions($query)
	{
		$list=array();
		$manufactures = self::groupBy('manufacture')->lists('manufacture');
		foreach ($manufactures as $manufacture) {
			$list = array_add($list, $manufacture, self::where('manufacture', '=', $manufacture)->lists('name', 'id'));
		}
		$list =array_add($list, '', 'Select car model');
		return $list;
	}

}