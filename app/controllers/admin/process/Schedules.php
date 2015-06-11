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
use \Station;
use \Booking;
use \Trip;
use \Rute;
use \Schedule;

class Schedules extends Admin {

	protected $station;
	protected $form = 'admin.process.schedules.form';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@routes', array('only' =>
                            array('create','store','edit','update', 'index')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$schedules = Schedule::filter(Input::get('filter'))->paginate(1);
		return $this->respondTo(
			array('html'=> function() use ($schedules)
				 			{
				 			 $this->layout->nest('content', $this->view, ['schedules' => $schedules, 'options' => $this->options]);
				 			},
				  'js' => function() use ($schedules)
				  		  {
				  		  	 return View::make('admin.process.schedules.table', array('schedules' => $schedules, 'options' => $this->options))->render();
				  		  }
				 )
			);
	}

	public function create()
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('schedule' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('schedule' => $this->resource, 'options' => $this->options))->render();
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
				 			 $this->layout->nest('content', $this->view, array('schedule' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('schedule' => $this->resource, 'options' => $this->options))->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}

	public function update($id)
	{
		return $this->save('edit');
	}

	protected function save($method)
	{
		if ($this->resource->save_a_schedule(Input::all()) ){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($method)
	        				  {
	        				  	$notice = $method == 'create' ? "created" : "updated";
	        				  	return Redirect::route('admin.process.schedules.index')
	            				->with('notice', 'Schedule is '.$notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('route', 'route.departure', 'route.category');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.process.schedules.'.$method, array('schedule' => $this->resource, 'errors' => $this->resource->errors, 'options' => $this->options));
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


}
