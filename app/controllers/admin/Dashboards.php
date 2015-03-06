<?php
namespace admin;
use \View;

class Dashboards extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make($this->view());
	}


}
