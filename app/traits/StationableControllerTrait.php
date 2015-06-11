<?php
namespace traits;

use \View;
use \Response;
use \Input;
use \Redirect;
use \App;
use \Car;
use \Category;
use traits\StationAbleControllerTrait;

trait StationAbleControllerTrait{

	public function edit_stationed_at($id)
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', 'admin.master.shared.edit_stationed_at', array('stationable_object' => $this->resource, 'options' => $this->options));
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make('admin.master.shared.stationable_form', array('stationable_object' => $this->resource, 'options' => $this->options))->render();
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
		);

	}

	public function stationed_at($id)
	{
		if ($this->resource->update_station(Input::get('station_id')))
		{
			return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	return Redirect::route('admin.master.'.strtolower(class_basename($this)).'.show', [strtolower(class_basename($this)) => $this->resource->id])
	            				->with('notice', strtolower(class_basename($this->resource)).' is now stationed at '. $this->resource->last_stationed_at->station->name);
	        				  },
	        		'js' => function()
	        				{
	        					return $this->resource->load('stationeds','stationeds.station');
	        				}
	        		)
	        	);
		}
		else{
			return  $this->respondTo(
				array('html'=> function()
					 			{
					 			 return $this->layout->nest('content', 'admin.master.shared.edit_stationed_at', array('stationable_object' => $this->resource, 'errors' => $this->resource->errors, 'options' => $this->options));
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