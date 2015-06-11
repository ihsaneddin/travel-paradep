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
use \Booking;
use \Trip;
use \Route;

class Bookings extends Admin {

	protected $trip;
	protected $form = 'admin.process.trips.bookings.form';
	protected $restrict_resource = 'trip.route.departure_id';

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@trip', array('only' =>
                            array('create','store', 'move', 'cancel', 'payment')));
		$this->beforeFilter('@avalaibleSeats', array('only' => array('create', 'store')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bookings = Booking::filter($this->filter_params())->paginate(1);
		return $this->respondTo(
			array('html'=> function() use ($bookings)
				 			{
				 			 $this->layout->nest('content', $this->view, ['bookings' => $bookings, 'options' => $this->options]);
				 			},
				  'js' => function() use ($bookings)
				  		  {
				  		  	 return View::make('admin.process.bookings.table', array('bookings' => $bookings, 'options' => $this->options))->render();
				  		  }
				 )
			);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($trip_id)
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('booking' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('booking' => $this->resource, 'options' => $this->options))->render();
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
	public function store($trip_id)
	{
		if ($this->resource->save_a_booking(Input::all()))
		{
			return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	$notice = 'Booking created.';
	        				  	return Redirect::route('admin.process.trips.show', ['trips' => $this->resource->trip_id])
	            				->with($notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('trip', 'passenger', 'trip.route');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function()
	    					  {
	    					  	 return $this->layout->nest('content', 'admin.process.trips.bookings.create', array('booking' => $this->resource, 'errors' => $this->resource->errors, 'options' => $this->options));
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


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, array('booking' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make('admin.process.bookings.detail', array('booking' => $this->resource, 'options' => $this->options))->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
			);
	}

	public function destroy($id)
	{
		//
	}

	public function payment($trip_id, $id)
	{
		if ($this->resource->setPayment() ){
			return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	$notice = "Booking payment state has been changed.";
	        				  	return Redirect::route('admin.process.bookings.show', ['bookings' => $this->resource->id])
	            				->with('notice', $notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('passenger', 'trip', 'trip.route');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function()
	    					  {
	    					  	 $error = implode(', ', $this->resource->first('state'));
	    					  	 return Redirect::route('admin.process.bookings.show', ['bookings' => $this->resource->id])
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

	public function cancel($trip_id, $id)
	{
		return $this->change_state('cancel');
	}

	public function move($trip, $id)
	{

	}

	protected function change_state($transition)
	{
		if ($this->resource->apply($transition) ){
			return $this->respondTo(
	        	array(
	        		'html' => function() use($transition)
	        				  {
	        				  	$notice = "Booking state has been changed.";
	        				  	return Redirect::route('admin.process.bookings.show', ['bookings' => $this->resource->id])
	            				->with('notice', $notice);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('passenger', 'trip', 'trip.route');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($transition)
	    					  {
	    					  	 $error = implode(', ', $this->resource->first('state'));
	    					  	 return Redirect::route('admin.process.bookings.show', ['bookings' => $this->resource->id])
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

	public function trip()
	{
		if (is_null($this->resource->trip))
		{
			$this->trip = Trip::findOrfail(Route::current()->getParameter('trips'));
			$this->resource->trip()->associate($this->trip);
		}
		if (!$this->resource->trip->hasProperty('editable'))
		{
			\App::abort(401, 'Not authenticated');
		}
	}

	public function avalaibleSeats()
	{
		$this->options['avalaible_seats'] = $this->resource->avalaibleSeatsNo();
	}

}
