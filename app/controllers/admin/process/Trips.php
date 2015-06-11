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
use \Rute;
use \Driver;
use \TravelCar;

class Trips extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $form = 'admin.master.trips.form';
	protected $restrict_resource = 'route.departure_id';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@routes', array('only' =>
                            array('create','store','edit','update', 'index')));
		$this->beforeFilter('@drivers', array('only' =>
                            array('create','store','edit','update', 'index','show')));
		$this->beforeFilter('@cars', array('only' =>
                            array('create','store','edit','update','index', 'show')));
		$this->beforeFilter('@categories', array('only' =>
                            array('index')));
		$this->beforeFilter('@stations', array('only' =>
                            array('index')));
		$this->beforeFilter('@updateAllowed', array('only' => array('edit', 'update')));
	}

	public function index()
	{
		$trips = Trip::filter($this->filter_params())->include()->paginate(1);
		return $this->respondTo(
			array('html'=> function() use ($trips)
				 			{
				 			 $this->layout->nest('content', $this->view, ['trips' => $trips, 'options' => $this->options]);
				 			},
				  'js' => function() use ($trips)
				  		  {
				  		  	 return View::make('admin.process.trips.table', array('trips' => $trips, 'options' => $this->options))->render();
				  		  }
				 )
			);
	}

	public function show($id)
	{
		$this->layout->nest('content', $this->view, ['trip' => $this->resource, 'options' => $this->options]);
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
				  		  	 $form = View::make($this->form, array('trip' => $this->resource, 'options' => $this->options))->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}

	public function store()
	{
		return $this->save('create');
	}

	public function edit($id)
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

	public function update($id)
	{
		return $this->save('edit');
	}

	public function ready($id)
	{
		return $this->change_state('set ready');
	}

	public function cancel($id)
	{
		return $this->change_state('cancel');
	}

	public function depart($id)
	{
		return $this->change_state('depart');
	}

	public function arrive($id)
	{
		return $this->change_state('arrive');
	}

	protected function change_state($transition)
	{
		if ($this->resource->apply($transition) ){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($transition)
	        				  {
	        				  	$notice = "Trip state has been changed.";
	        				  	return Redirect::route('admin.process.trips.show', ['trips' => $this->resource->id])
	            				->with('notice', $notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('driver', 'car', 'route', 'route.departure', 'route.destination');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($transition)
	    					  {
	    					  	$error = implode(', ', $this->resource->first('state'));
	    					  	 return Redirect::route('admin.process.trips.show', ['trips' => $this->resource->id])
	            				->with('error', $error);
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


	public function routes()
	{
		$this->options['routes'] = Rute::ListSelectInput($this->station_id);
		$routes = is_null($this->station_id) ? Rute::with('category') : Rute::where('departure_id', '=', $this->station_id)->with('category');
		$this->options['all_routes'] = $routes->get()->toArray();
	}

	public function drivers()
	{
		$this->options['drivers'] = Driver::ListSelectInput($this->station_id);
		$drivers = is_null($this->station_id) ? Driver::all() : Driver::currentStation($this->station_id);
		$this->options['all_drivers'] = $drivers->toArray();
	}

	public function cars()
	{
		$this->options['cars'] = TravelCar::ListSelectInput($this->station_id);
		$this->options['all_cars'] = TravelCar::all()->toArray();
	}

	public function updateAllowed()
	{
		if (!$this->resource->hasProperty('editable'))
		{
			\App::abort(401, 'Not authenticated');
		}
	}

	protected function save($method)
	{
		if ($this->resource->store($this->trip_attributes()) ){
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
	        					return $this->resource->load('driver', 'car', 'route', 'route.departure', 'route.destination');
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

	protected function trip_attributes()
	{
		$trip_attributes = Input::all();
		if (array_key_exists('departure_date', $trip_attributes))
		{
			$trip_attributes['departure_date'] = format_date_time($trip_attributes['departure_date'], 'Y-m-d');
		}
		if (array_key_exists('arrival_date', $trip_attributes))
		{
			$trip_attributes['arrival_date'] = format_date_time($trip_attributes['arrival_date'], 'Y-m-d');
		}
		return $trip_attributes;
	}


}
