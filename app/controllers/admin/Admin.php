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
use \Confide;

class Admin extends \BaseController {

	public $layout = 'layouts.admin';
	protected $form;
	protected $resource;
	protected $status = 401;
	protected $errors;
	protected $model;
	protected $options = array();


	public function __construct()
	{
		$currentUrl = Request::url();
		View::share('currentUrl', $currentUrl);
		View::share('currentUser', Confide::user());
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

	protected function resource()
	{
		$resource = is_null($this->model) ? str_singular(class_basename(get_class($this))) : $this->model;
		if (class_exists($resource))
		{
			$resourceId = Route::current()->getParameter(strtolower(class_basename(get_class($this))));
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

	public function destroy($id)
	{
		$this->resource->delete() ? $this->status = 200 : $this->status = 422;
		return Response::json(null, $this->status);
	}

	public function categories()
	{
		$this->options['categories'] = \Category::ClassListSelectInput();
	}

	public function stations()
	{
		$this->options['stations'] =  \Station::stationListSelectOptions();
	}

	public function filter_params()
	{
		$filter = Input::get('filter');
		return empty($filter) ? array() : $filter;
	}

}
