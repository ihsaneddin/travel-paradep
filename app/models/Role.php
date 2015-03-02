<?php
class Role extends Base {
	protected $table = 'roles';
	protected $fillable = ['name', 'description'];
	public $timestamps = false;

	public function users()
	{
		return $this->belongsToMany('User','users_roles');
	}
	public function permissions()
	{
		return $this->belongsToMany('Permission', 'roles_permissions');
	}
	public function hasPermission($route)
	{
		foreach ($this->permissions as $permission) {
			if ($permission->key == $route)
			{
				return true;
			}
		}
		return false;
	}
	public function scopeValid($res)
	{
		return $res->where('name','<>','super_admin');
	}
	public static function autocompleteAll()
	{
		$roles=array();
		foreach (Role::select('id', 'name')->valid()->get() as $role) {
			$roles[] = ['id' => $role->id, 'name' => $role->name]	;
		} 
		return $roles;
	}
}