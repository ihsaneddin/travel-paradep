<?php
use Illuminate\Support\MessageBag;

class Helpers {

	public static function foo()
	{
		return 'foo';
	}

	public static function avatar()
	{
		$avatar = asset('assets/img/avatar-default.png');
		if ( ! is_null(Confide::user()->avatar ) )
		{
			$avatar = asset(Confide::user()->avatar->url());
		}
		return $avatar;
	}

	public static function tableTitle()
	{
		$function = implode(' ', explode('_', self::currentResource()['function'])).' '.ucfirst(self::currentResource()['controller']);
		return '<h3 class="panel-title pull-left"> '.$function.'</h3>';
	}

	static function modalTitle()
	{
		$function = implode(' ', explode('_', self::currentResource()['function'])).' '.ucfirst(self::currentResource()['controller']);
		return '<h4 class="modal-title">'.ucfirst($function).'</h4>';
	}

	public static function currentResource()
	{
		$arr = explode('.', Route::current()->getName());
		return array( 'function' => strtolower(array_pop($arr)),
					  'controller' => strtolower(end($arr)));
	}

	public static function currentBreadcrumbs($obj=null)
	{
		return call_user_func_array(array('Breadcrumbs','render'), array(Route::current()->getName(),$obj));
	}

	static function link_to($route, $name, $routeOptions= array(), $htmlAttributes = array() )
	{
		$attributes = '';
		foreach ($htmlAttributes as $attr => $value) {
			$attributes = $attributes.' '.$attr.'="'.$value.'" ';
		}
		return '<a href="'.route($route, $routeOptions).'" '.$attributes.'> '.$name.' </a>';

	}

	static function autocomplete($data,$id)
	{
		return '<div id="autocomplete-avalaible-'.$id.'" class="auto-complete">'.json_encode($data).'</div>';
	}

	static function currentAutocomplete($data, $id)
	{
		return '<div id="autocomplete-prepopulate-'.$id.'" class="auto-complete">'.json_encode($data).'</div>';
	}

	static function inputError($errors,$property)
	{
		//if ( self::isMessageBag($errors) )
		//{
			if ($errors->has($property)) return 'has-error';
		//}
	}

	static function errorMessage($errors, $property)
	{
		if ( self::isMessageBag($errors) ) $errors->first($property);

	}

	static function isMessageBag($errors)
	{
		if ( $errors instanceOf MessageBag ) return true;
	}

	static function createOrUpdateRoute($obj,array $route= array())
	{
		$currentBaseRoute = explode('.', Route::current()->getName());
		array_pop($currentBaseRoute);
		$method = is_null($obj->id) ? 'store' : 'update';
		$id = is_null($obj->id) ? '' : $obj->id;
		array_push($currentBaseRoute, $method);
		array_push($route, implode('.', $currentBaseRoute));
		if($id !== '') array_push($route, $id);
		return $route;
	}

	static function createOrUpdateMethod($object)
	{
		$method = $object->id ? 'put' : 'post';
		return $method;
	}

	static function carClassList($categories)
	{
		$list = array();
		foreach ($categories as $category) {
			$list = array_add($list, $category->id, ucfirst($category->name));
		}
		return $list;
	}

	static function showOrHidden($condition)
	{
		if (empty($condition)) return 'hidden';
	}

}