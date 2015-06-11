<?php
namespace api\datatable;

use \TravelCar;
use \Input;
use \Table;
use api\Api;

class Cars extends Api {

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
		return Table::collection(TravelCar::with('category', 'model')->get())
        ->addColumn('Code', function($car){
            return '<span class="code">'.$car->code.'</a></span>';
        })
        ->addColumn('Name', function($car){
            return '<span class="name"><a href="'.route('admin.master.cars.show', ['car' => $car->id ]).'">'.$car->model->name.'</a></span>';
        })
        ->addColumn('Manufacture', function($car){
    		return '<span class="manufacture">'.$car->model->manufacture.'</span>';
        })
        ->addColumn('License Number', function($car){
        	return '<span class="license-number">'.$car->license_no.'</span>';
        })
        ->addColumn('Class', function($car){
        	return '<span class="class">'.$car->category->name.'</span>';
        })
        ->addColumn('Seat', function($car){
        	return '<span class="seat">'.$car->seat.'</span>';
        })
        ->addColumn('State', function($car){
        	return '<span class="state">'.$car->state.'</span>';
        })
        ->addColumn('Stationed At', function($car){
        	return '<span class="stationed-at">'.$car->stationed_name.'</span>';
        })
        ->addColumn('action', function($car){
        	$str = '<div class="btn-group action">
                		<a href="'.route('admin.master.cars.edit', ['cars' => $car->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-car-'.$car->id.'" "><i class="icon icon-pencil"></i></a>
                        <a href="'.route('admin.master.cars.edit_stationed_at', ['cars' => $car->id]).'" class="btn btn-default btn-xs new-modal-form"  data-target="modal-edit-stationed-car-'.$car->id.'" data-form-url="'.route('admin.master.cars.stationed_at', array('cars' => $car->id)).'"><i class="icon icon-screenshot"></i></a>
                		<a id ="delete-record-'.$car->id.'" href="'.route('admin.master.cars.destroy', ['cars' => $car->id]).'" class="btn btn-default btn-delete btn-xs delete-table-record confirm" data-method="delete"><i class="icon icon-trash"></i></a>
            		</div>';
            return $str;
        })
        ->searchColumns('Name', 'Manufacture','License Number', 'State', 'Seat')
        ->orderColumns('name', 'manufacture', 'state', 'seat')
        ->make();
	}
}
