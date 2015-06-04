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
use \Route;


class Routes extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $model = 'Rute';
	protected $form = 'admin.master.routes.form';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@categories', array('only' =>
                            array('create','store','edit','update')));
		$this->beforeFilter('@stations', array('only' =>
                            array('create','store','edit','update')));

	}

	public function index()
	{
		$this->layout->nest('content', $this->view, ['routes' => $this->datatable()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('route' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('route' => $this->resource, 'options' => $this->options))->render();
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
		$this->layout->nest('content', $this->view, array('route' => $this->resource));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('route' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('route' => $this->resource, 'options' => $this->options))->render();
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

	protected function datatable()
	{
		return Table::table()->addColumn('Name', 'Code', 'From', 'Destination', 'Category','Price', 'Action')
							 ->setUrl(route('api.datatable.routes.index'))
							 ->noScript();
	}

	protected function save($method)
	{
		if ($this->resource->store(Input::all())){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($method)
	        				  {
	        				  	$notice = $method == 'create' ? "created" : "updated";
	        				  	return Redirect::route('admin.master.routes.show', ['routes' => $this->resource->id])
	            				->with('notice', 'Route is '.$notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('departure','destination');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.master.routes.'.$method, array('route' => $this->resource, 'errors' => $this->resource->errors, 'options' => $this->options));
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
