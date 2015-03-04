<?php

namespace admin;

use \Input;
use \View;

class Profiles extends Admin {

	protected $resource;
	protected $form = 'admin.profiles.form';

	public function __construct()
	{
		$this->resource = $this->resource('User');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->resource->childs['avatar'][0] = new \Attachment; 
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, ['user' => $this->resource]);
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->form, array('user' => $this->resource))->render(); 
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
		if ($this->resource->store(Input::all())) {
	        return $this->respondTo(
	        	array(
	        		'html' => function()
	        				  {
	        				  	return Redirect::route('admin.profiles.show', ['users' => $this->resource->id])
	            				->with('notice', 'Profile updated');
	        				  }, 
	        		'js' => function()
	        				{
	        					return $this->resource;
	        				}
	        		)
	        	);
	     }
	    else {
	    	return $this->respondTo(
	    		array(
	    			'html' => function()
	    					  {
	    					  	return Redirect::action('admin\master\Users@create', ['user' => $this->resource])
			                ->withInput(Input::except('password'))
			                ->withErrors($this->resource->errors());
	    					  },
	    			'js' => function()
	        			{
	        				return $this->resource->errors();	
	        			},
	        	'status' => 422
	    			)
	    		);
	    } 
	}


}
