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
use \Address;
use traits\StationAbleControllerTrait;

class Drivers extends Admin {
	use StationAbleControllerTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $form = 'admin.master.drivers.form';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@stations', array('only' =>
                            array('create','store','edit','update', 'edit_stationed_at', 'stationed_at')));
	}

	public function index()
	{
		$this->layout->nest('content', $this->view, ['drivers' => $this->datatable()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->resources = array('driver' => $this->resource);
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
		$this->layout->nest('content', $this->view, ['driver' => $this->resource]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->resources = array('driver' => $this->resource
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

	private function datatable()
	{
		return Table::table()->addColumn('Name', 'Code', 'Drive Hours', 'State', 'Stationed At', 'Action')
							 ->setUrl(route('api.datatable.drivers.index'))
							 ->noScript();
	}

	private function save($method)
	{
		if ($this->resource->store(Input::all())){
			return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	return Redirect::route('admin.master.drivers.show', ['drivers' => $this->resource->id])
	            				->with('notice', 'Station created');
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource;
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.master.drivers.'.$method, array('driver' => $this->resource, 'errors' => $this->resource->errors));
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
