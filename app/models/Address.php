<?php

class Address extends Base
{
	protected $table = 'addresses';
	protected $fillable = ['name', 'city', 'state'];

	public function addressable()
    {
        return $this->morphTo();
    }

	public function rules()
	{
		$this->rules =  array('name' => 'required',
						'city' => 'required',
						'state' => 'required');
	}

}