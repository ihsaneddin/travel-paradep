<?php
namespace admin\master;
use admin\Admin;
use \Table;
use \View;
use \Response;
use \Input;
use \Redirect;
use \App;
use \Address;

class Schedules extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $form = 'admin.master.schedules.form';

	public function index()
	{
    	$this->layout->nest('content', $this->view, ['schedules' => $this->datatable()]);
	}

	protected function datatable()
	{
		return Table::table()->addColumn('Station', 'Route', 'Hour','Weekend', 'Class', 'Action')
							 ->setUrl(route('api.datatable.schedules.index'))
							 ->noScript();
	}

}
