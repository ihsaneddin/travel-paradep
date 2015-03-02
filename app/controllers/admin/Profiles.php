<?php

namespace admin;

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
		return  $this->respondTo(
			array('html'=> function()
				 			{
				 			 $this->layout->nest('content', $this->view, ['user' => $this->resource]);
				 			},
				  'js' => function()
				  		  {
				  		  	 $form = \View::make($this->form, array('user' => $this->resource))->render(); 
				  		  	 return \View::make('admin.shared.modal', array('body' => $form))->render();
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
		//
	}


}
