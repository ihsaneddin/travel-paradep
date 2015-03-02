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
		return User::datatable();
	}


}
