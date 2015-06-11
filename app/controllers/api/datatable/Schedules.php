<?php
namespace api\datatable;

use \Schedule;
use \Input;
use \Table;
use api\Api;

class Schedules extends Api {

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

	}
}
