<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;

class User extends Base implements ConfideUserInterface {

	use ConfideUser;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $fillable = ['username','email', 'password', 'password_confirmation']; 
	protected $acceptNestedAttributes = ['avatar' => ['id', 'name', 'description', 'image', '_delete']];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function roles()
	{
		return $this->belongsToMany('Role', 'users_roles');
	}

	public function avatar()
	{
		return $this->hasOne('Attachment');
	}

	public function addRole($name)
	{
		$role = Role::where('name',$name)->get()->first();
		if (is_null($role))
		{
			$role = Role::create(['name'=> $name]);
		}
		$role->users->attach($this->attributes['id']);
		return true;
	}

	public function hasRole($name)
	{
		$role = $this->roles()->where('name', $name)->first();
		if (!is_null($role))
		{
			return true;
		}
	}

	public function scopeFilter($res, $filter)
	{
		if (!empty($filter))
		{
			$query = array(); 
				if  (!is_null($filter['name']))
			{
				array_push($query, 'Lower(username) like "%'.$filter['name'].'%"');
				//$res = $res->whereRaw("Lower(name) like  '%?%'", $filter['name']);
			}
			else if (!is_null($filter['email']))
			{
				array_push($query, 'Lower(email) like "%'.$filter['email'].'%"');
				//$res = $res->whereRaw('Lower(email) like "%?%"', $filter['email']);
			}
			$res = $res->whereRaw(implode(' and ', $query));
		}
		return $res;
	}

	public function scopeValidDatatable($res)
	{
		return $res->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
			       ->leftJoin('roles', 'roles.id', '=', 'users_roles.role_id')
			       ->select('users.id', 'username', 'email', 'last_login', 'users_roles.user_id', 'users_roles.role_id', 'roles.name', 'users.updated_at')
			       ->where('roles.name', '<>', 'super_admin')->orderBy('users.updated_at', 'ASC');
	}

	static function dataTable()
	{
		$users = self::validDatatable()->with('roles')->get();

	    return Table::collection($users)
	        ->addColumn('username', function($user){
	            return '<span class="username"><a href="'.route('admin.master.users.show', ['users' => $user->id ]).'">'.$user->username.'</a></span>';
	        })
	        ->addColumn('email', function($user){
	        	return '<span class="email">'.$user->email.'</span>';
	        })
	        ->addColumn('role', function($user){
        		return '<span class="roles">'.$user->rolesName().'</span>';
	        })
	        ->addColumn('last_login', function($user){
	        	return '<span class="last_login">'.$user->lastLogin().'</span>';
	        })
	        ->addColumn('action', function($user){
	        	$str = '<div class="btn-group action">
                    		<a href="'.route('admin.master.users.edit', ['users' => $user->id]).'" class="btn btn-default btn-xs"><i class="icon icon-pencil"></i></a>
                    		<a id = "delete-record-'.$user->id.'" href="'.route('admin.master.users.destroy', ['users' => $user->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record" onclick="deleteRowRecord(event,this);" data-method="delete"><i class="icon icon-trash"></i></a>
                		</div>';
                return $str;
	        })
	        ->searchColumns('username', 'email', 'role')
	        ->orderColumns('username', 'email', 'role')
	        ->make();
	}

	public function valid()
	{
		if (!$this->hasRole('super_admin')) return true;
	}

	public function currentRolesAutocomplete()
	{
		$this->roles();
	}

	public function nowLogin()
	{
		$this->last_login = date('Y-m-d G:i:s');
		$this->save();
	}

	public function lastLogin()
	{
		$this->last_login == '0000-00-00 00:00:00' ? $lastLogin='Never' : $lastLogin = date('M j, Y h:i A', strtotime($this->last_login));
		return $lastLogin;
	}

	public function rolesName(array $names = array())
	{
		foreach ($this->roles as $role) {
			array_push($names, $role->name);
		}
		return implode(' ,', $names);
	}

}
