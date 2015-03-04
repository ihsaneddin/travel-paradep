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

class Users extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	protected $resource;
	protected $form = 'admin.master.users.form';

	public function index()
	{	
		$users = Table::table()->addColumn('Username', 'Email', 'Role','Last Login', 'Action')
							   ->setUrl(route('api.datatable.users.index'))
							   ->noScript();
    	$this->layout->nest('content', $this->view, ['users' => $users]);
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$repo = App::make('UserRepository');
	    $user = $repo->signup(Input::all());
	    if ($user->id) {
	        return $this->respondTo(
	        	array(
	        		'html' => function() use($user)
	        				  {
	        				  	return Redirect::route('admin.master.users.show', ['users' => $user->id])
	            				->with('notice', 'User created');
	        				  }, 
	        		'js' => function() use($user)
	        				{
	        					return $user->load('roles');
	        				}
	        		)
	        	); 
	    } else {
	    	return $this->respondTo(
	    		array(
	    			'html' => function() use ($user)
	    					  {
	    					  	return Redirect::action('admin\master\Users@create')
			                ->withInput(Input::except('password'))
			                ->withErrors($user->errors());
	    					  },
	    			'js' => function() use ($user)
	        			{
	        				return $user->errors();	
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
		$this->layout->nest('content', $this->view, ['user' => $this->resource]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->layout->nest('content', $this->view, ['user' => $this->resource]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->resource->valid())
		{
			$this->resource->delete() ? $this->status = 200 : $this->status = 422;
		}
		return Response::json(null, $this->status);
	}


}
