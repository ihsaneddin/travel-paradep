<?php
namespace api\datatable;

use \Driver;
use \Input;
use \Table;
use api\Api;

class Drivers extends Api {

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
		return Table::collection(Driver::all())
	        ->addColumn('name', function($driver){
	            return '<span class="name"><a href="'.route('admin.master.drivers.show', ['drivers' => $driver->id ]).'">'.$driver->name.'</a></span>';
	        })
	        ->addColumn('code', function($driver){
	        	return '<span class="code">'.$driver->code.'</span>';
	        })
	        ->addColumn('driver_hours', function($driver){
        		return '<span class="address">'.$driver->drive_hours.' hour(s)</span>';
	        })
	        ->addColumn('action', function($driver){
	        	$str = '<div class="btn-group action">
                    		<a href="'.route('admin.master.drivers.edit', ['drivers' => $driver->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-driver-'.$driver->id.'" "><i class="icon icon-pencil"></i></a>
                    		<a id = "delete-record-'.$driver->id.'" href="'.route('admin.master.drivers.destroy', ['drivers' => $driver->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record confirm" data-method="delete"><i class="icon icon-trash"></i></a>
                		</div>';
                return $str;
	        })
	        ->searchColumns('name', 'code')
	        ->orderColumns('name', 'code')
	        ->make();
	}


}
