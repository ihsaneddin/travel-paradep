<?php
namespace admin\master;
use admin\Admin;
use \Table;
use \View;
use \Response;
use \User;
use \Input;
use \Redirect;
use \App;
use \Session;
use \Station;

class Stations extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $form = 'admin.master.stations.form';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@build_addresses', array('only' =>
                            array('create')));
	}

	public function index()
	{
		$this->layout->nest('content', $this->view, ['stations' => $this->datatable()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->resources = array('station' => $this->resource);
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, $this->resources);
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, $this->resources)->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return $this->save('create');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$this->layout->nest('content', $this->view, ['station' => $this->resource]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->resources = array('station' => $this->resource
 						);
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, $this->resources);
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, $this->resources)->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return $this->save('edit');
	}

	public function build_addresses()
	{
		if ($this->resource->addresses->isEmpty())
		{
			$address = new \Address;
			$this->resource->addresses->push($address);
		}
	}

	private function datatable()
	{
		return Table::table()->addColumn('Name', 'Code', 'Address','Action')
							 ->setUrl(route('api.datatable.stations.index'))
							 ->noScript();
	}

	private function save($method)
	{
		if ($this->resource->store(Input::all())){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($method)
	        				  {
	        				  	$notice = $method == 'create' ? "created" : "updated";
	        				  	return Redirect::route('admin.master.stations.show', ['stations' => $this->resource->id])
	            				->with('notice', 'Station is '.$notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('addresses');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.master.stations.'.$method, array('station' => $this->resource, 'errors' => $this->resource->errors));
	    					  },
	    			'js' => function()
	        			{
	        				return $this->resource->errors;
	        			},
	        	'status' => 422
	    			)
	    		);
		}
	}

}
