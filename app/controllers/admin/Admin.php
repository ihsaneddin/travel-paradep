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
	protected $current_user;
	protected $restrict_resource;
	protected $station_id;


	public function __construct()
	{
		$currentUrl = Request::url();
		View::share('currentUrl', $currentUrl);
		$this->setView();
		$this->setResource();
		$this->setCurrentUser();
		$this->setStation();
		View::share('currentUser', $this->current_user);
		$this->beforeFilter('@restrictResource');
	}

	protected function setView()
	{
		$this->view = Route::current()->getName();
	}

	public function restrictResource($resource = null)
	{
		$resource = is_null($resource) ? $this->resource : $resource;
		if (!$this->current_user->hasRole('super_admin'))
		{
			if (!empty($this->restrict_resource))
			{
				$restricts = explode('.', $this->restrict_resource);
				$actual_resource = $resource;
				foreach ($restricts as $def) {
					if ($def != end($restricts))
					{
						$actual_resource = $actual_resource->$def()->first();
					}else{
						if ($actual_resource->$def != $this->station_id)
						{
							\App::abort(401, 'Not authenticated');
						}
					}

				}
			}
		}
	}

	protected function setStation()
	{
		$this->station_id = $this->current_user->station_id;
	}

	protected function setResource()
	{
		$this->resource = $this->resource();
	}

	protected function setCurrentUser()
	{
		$this->current_user = Confide::user();
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
