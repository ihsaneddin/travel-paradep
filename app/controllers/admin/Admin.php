<?php
namespace admin;
use \Route;
use \Request;
use \View;
use \Response;
use \User;
use \Input;
use \Table;
use \Redirect;
use \App;
use \Session;

class Admin extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public $layout = 'layouts.admin';
	protected $resource;
	protected $status = 401;
	protected $errors;

	public function __construct()
	{
		$currentUrl = Request::url();
		View::share('currentUrl', $currentUrl);
		$this->view = Route::current()->getName();
		$this->resource = $this->resource();
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$layout = Request::ajax() ? 'layouts.ajax' : $this->layout;
			$this->layout = View::make($layout);
		}
	}

	protected function resource($resource=null)
	{
		$resource = is_null($resource) ? str_singular(class_basename(get_class($this))) : $resource;
		if (class_exists($resource))
		{
			$resourceId = Route::current()->getParameter(strtolower(class_basename(get_class($this))));
			//dd(array($resourceId));
			if ( is_null($resourceId) )
			{
				return new $resource;
			}
			else
			{
				return call_user_func_array(array($resource, 'findOrFail'), array($resourceId));
			}
		} 
	}
	//params options expect closure
	protected function respondTo(array $options=array())
	{
		$response = null;
		if (Request::ajax())
		{
			if (is_callable($options['js']))
			{
				$response =  Response::json($options['js'](), array_key_exists('status', $options) ? $options['status'] : 200 );
			}	
		}
		else
		{
			if (is_callable($options['html']))
			{
				$response = $options['html']();
			}	
		}
		return $response;
	}

}
