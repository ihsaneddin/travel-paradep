<?php

namespace admin;

use \Input;
use \View;


class Profiles extends Admin {

	protected $resource;
	protected $form = 'admin.profiles.form';
	protected $passwordForm = 'admin.profiles.password_form';

	public function __construct()
	{
		$this->resource = \Confide::user();
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
		$this->resource->avatar = strlen(Input::get('_delete')) ? : STAPLER_NULL ;  
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
	    					  	return Redirect::action('admin\Profiles@edit', ['user' => $this->resource])
				                ->withInput(Input::all())
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

	public function new_password($id)
	{
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, ['user' => $this->resource]);
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = View::make($this->passwordForm, array('user' => $this->resource))->render(); 
				  		  	 return View::make('admin.shared.modal', array('body' => $form))->render();
				  		  }
				 )
		);
	}

	public function change_password($id)
	{

		if ($this->resource->changePassword(Input::all())) {
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
	    					  	return Redirect::action('admin\Profiles@change_password', ['user' => $this->resource])
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
