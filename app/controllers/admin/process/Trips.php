<?php
namespace admin\process;
use admin\Admin;
use \Table;
use \View;
use \Response;
use \User;
use \Input;
use \Redirect;
use \App;
use \Session;
use \Trip;

class Trips extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $form = 'admin.master.trips.form';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@routes', array('only' =>
                            array('create','store','edit','update')));
		$this->beforeFilter('@drivers', array('only' =>
                            array('create','store','edit','update')));
		$this->beforeFilter('@cars', array('only' =>
                            array('create','store','edit','update')));
	}

	public function index()
	{
		$trips = Trip::filter(Input::get('filter'))->paginate(20);
		$this->layout->nest('content', $this->view, ['trips' => $trips, 'options' => $this->options]);
	}

	public function show($id)
	{

	}

	public function create()
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('trip' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, $this->resource)->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}

	public function store()
	{
		return $this->save('create');
	}


	public function routes()
	{
		$this->options['routes'] = \Rute::ListSelectInput();
		$this->options['all_routes'] = \Rute::all()->toArray();
	}

	public function drivers()
	{
		$this->options['drivers'] = \Driver::ListSelectInput();
		$this->options['all_drivers'] = \Driver::all()->toArray();
	}

	public function cars()
	{
		$this->options['cars'] = \TravelCar::ListSelectInput();
		$this->options['all_cars'] = \TravelCar::all()->toArray();
	}

	protected function save($method)
	{
		if ($this->resource->store(Input::all()) ){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($method)
	        				  {
	        				  	$notice = $method == 'create' ? "created" : "updated";
	        				  	return Redirect::route('admin.process.trips.show', ['trips' => $this->resource->id])
	            				->with('notice', 'Trip is '.$notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('driver','route', 'departure', 'destination');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.process.trips.'.$method, array('trip' => $this->resource, 'errors' => $this->resource->errors, 'options' => $this->options));
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
