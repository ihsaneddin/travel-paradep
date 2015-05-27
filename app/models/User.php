<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;
use traits\NestedAttributes;
use traits\Validator;
use interfaces\NestedAttributesInterface;
use interfaces\ValidatorInterface;
use observers\UserObserver;
use Illuminate\Events\Dispatcher;
use interfaces\ChangePasswordInterface;
use traits\ChangePassword;

class User extends Eloquent implements ConfideUserInterface, StaplerableInterface, NestedAttributesInterface, ValidatorInterface, ChangePasswordInterface{
	use ConfideUser;
	use EloquentTrait;
	use Validator;
	use NestedAttributes;
	use ChangePassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $fillable = ['username','email', 'avatar', 'station_id'];
	protected $validator;
	protected $rules = array();
 	protected $messages = array();
 	protected $appends = ['avatar_url'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function __construct(array $attributes =array())
	{
		$this->hasAttachedFile('avatar', [
			'styles' => [
				'medium' => '300x300',
				'thumb' => '100x100'
			]
		]);
		$this->isMessageBag();
		parent::__construct($attributes);
	}

	public function roles()
	{
		return $this->belongsToMany('Role', 'users_roles');
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
			}
			else if (!is_null($filter['email']))
			{
				array_push($query, 'Lower(email) like "%'.$filter['email'].'%"');
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
                    		<a href="'.route('admin.master.users.edit', ['users' => $user->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-user-'.$user->id.'" onclick="newModalForm(event,this)"><i class="icon icon-pencil"></i></a>
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

	public function getAvatarUrlAttribute($value)
	{
		return is_null($this->avatar_file_name) ? asset('assets/img/avatar-default.png') : asset($this->avatar->url());
	}


}
