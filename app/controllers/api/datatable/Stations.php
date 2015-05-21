<?php
namespace api\datatable;

use \Station;
use \Input;
use \Table;
use api\Api;

class Stations extends Api {

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
	    return Table::collection(Station::with('addresses')->get())
	        ->addColumn('name', function($station){
	            return '<span class="name"><a href="'.route('admin.master.stations.show', ['stations' => $station->id ]).'">'.$station->name.'</a></span>';
	        })
	        ->addColumn('code', function($station){
	        	return '<span class="code">'.$station->code.'</span>';
	        })
	        ->addColumn('address', function($station){
        		return '<span class="address">'.$station->address.'</span>';
	        })
	        ->addColumn('action', function($station){
	        	$str = '<div class="btn-group action">
                    		<a href="'.route('admin.master.stations.edit', ['stations' => $station->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-station-'.$station->id.'" "><i class="icon icon-pencil"></i></a>
                    		<a id = "delete-record-'.$station->id.'" href="'.route('admin.master.stations.destroy', ['stations' => $station->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record" onclick="deleteRowRecord(event,this);" data-method="delete"><i class="icon icon-trash"></i></a>
                		</div>';
                return $str;
	        })
	        ->searchColumns('name', 'code')
	        ->orderColumns('name', 'code')
	        ->make();
	}


}
