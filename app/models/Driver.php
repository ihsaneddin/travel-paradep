<?php

class Driver extends Base
{
	protected $table = 'drivers';
	protected $fillable = ['name', 'code'];

	public function addressable()
    {
        return $this->morphTo();
    }

	public function rules()
	{
		$this->rules =  array('name' => 'required',
						'code' => 'required|unique:drivers,code,'.$this->id);
	}

	public function scopeListSelectInput($res)
	{
		$list = array();
		foreach ($res->get() as $driver) {
			$list = array_add($list, $driver->id, $driver->code);
		}
		$list = array_add($list, '', 'Select driver...');
		return $list;
	}

}