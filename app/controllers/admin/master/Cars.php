<?php
namespace admin\master;

use admin\Admin;
use \Table;
use \View;
use \Response;
use \Input;
use \Redirect;
use \App;
use \Car;
use \Category;
use traits\StationAbleControllerTrait;

class Cars extends Admin {

	use StationAbleControllerTrait;

	protected $form = 'admin.master.cars.form';
	protected $model = 'TravelCar';
	protected $resources = array();

	public function __construct()
	{
		parent::__construct();
		$this->beforeFilter('@stations', array('only' =>
                            array('create','store','edit','update', 'edit_stationed_at', 'stationed_at')));
	}

	public function index()
	{
    	$this->layout->nest('content', $this->view, ['cars' => $this->datatable()]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->resources = array('car' => $this->resource,
 						'categories' => Category::ClassListSelectInput(),
 						'carList' => Car::carListSelectOptions()
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
		$this->layout->nest('content', $this->view, ['car' => $this->resource]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->resources = array('car' => $this->resource,
 								 'categories' => Category::ClassListSelectInput(),
 								 'carList' => Car::carListSelectOptions()
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
		return Table::table()->addColumn('Code', 'Name', 'Manufacture','License Number', 'Class', 'Seat', 'State', 'Stationed At', 'Action')
							 ->setUrl(route('api.datatable.cars.index'))
							 ->noScript();
	}

	private function save($method)
	{
		if ($this->resource->saveATravelCar(Input::all())){
			return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	return Redirect::route('admin.master.cars.show', ['cars' => $car->id])
	            				->with('notice', 'Car created');
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('category', 'model', 'photos');
	        				}
	        		)
	        	);
		}else{
			return $this->respondTo(
	    		array(
	    			'html' => function() use($method)
	    					  {
	    					  	return Redirect::action('admin\master\Cars@'.$method)
				                ->withInput(Input::all())
				                ->withErrors($this->resource->errors);
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
