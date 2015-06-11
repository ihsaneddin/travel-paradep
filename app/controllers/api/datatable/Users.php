<?php
namespace api\datatable;

use \User;
use \Input;
use \Table;
use api\Api;

class Users extends Api {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->datatable();
	}

	private function datatable()
	{
		$users = User::validDatatable()->with('roles', 'station')->get();

	    return Table::collection($users)
	        ->addColumn('username', function($user){
	            return '<span class="username"><a href="'.route('admin.master.users.show', ['users' => $user->id ]).'" class="new-modal-form" data-target="modal-show-user-'.$user->id.'">'.$user->username.'</a></span>';
	        })
	        ->addColumn('station', function($user){
	        	return '<span class="station">'.$user->station->name.'</span>';
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
	        	//<a href="'.route('admin.master.users.edit', ['users' => $user->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-user-'.$user->id.'""><i class="icon icon-pencil"></i></a>
	        	$str = '<div class="btn-group action">
                    		<a id = "delete-record-'.$user->id.'" href="'.route('admin.master.users.destroy', ['users' => $user->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record confirm" data-method="delete"><i class="icon icon-trash"></i></a>
                		</div>';
                return $str;
	        })
	        ->searchColumns('username', 'email', 'role', 'station')
	        ->orderColumns('username', 'email', 'role', 'station')
	        ->make();
	}


}
