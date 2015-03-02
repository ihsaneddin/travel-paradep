<?php

class Permission extends Base {
	protected $table = 'permissions';
	protected $fillable = ['name', 'key', 'description'];
	public $timestamp = false;

	public function roles()
	{
		return $this->belongsToMany('Role', 'roles_permissions');
	}
	public function getKey()
	{
		return $this->attributes['key'];
	}

}