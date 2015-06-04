<?php
namespace api\datatable;

use \Rute;
use \Input;
use \Table;
use api\Api;

class Routes extends Api {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->datatable();
	}

	private function datatable()
	{
		return Table::collection(Rute::all())
	        ->addColumn('name', function($route){
	            return '<span class="name"><a href="'.route('admin.master.routes.show', ['routes' => $route->id ]).'">'.$route->name.'</a></span>';
	        })
	        ->addColumn('code', function($route){
	        	return '<span class="code">'.$route->code.'</span>';
	        })
	        ->addColumn('from', function($route){
        		return '<span class="from"> '.$route->departure_station.'</span>';
	        })
	        ->addColumn('destination', function($route){
        		return '<span class="from">'.$route->destination_station.' </span>';
	        })
	        ->addColumn('class', function($route){
        		return '<span class="category">'.$route->category->name.' </span>';
	        })
	        ->addColumn('price', function($route){
        		return '<span class="price">'.$route->price.'</span>';
	        })
	        ->addColumn('action', function($route){
	        	$str = '<div class="btn-group action">
                    		<a href="'.route('admin.master.routes.edit', ['routes' => $route->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-route-'.$route->id.'""><i class="icon icon-pencil"></i></a>
                    		<a id = "delete-record-'.$route->id.'" href="'.route('admin.master.routes.destroy', ['routes' => $route->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record confirm" data-method="delete"><i class="icon icon-trash"></i></a>
                		</div>';
                return $str;
	        })
	        ->searchColumns('name', 'code')
	        ->orderColumns('name', 'code')
	        ->make();
	}


}
