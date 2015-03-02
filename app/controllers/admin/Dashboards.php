<?php
namespace admin;

class Dashboards extends Admin {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$att = new \Attachment;
		$att->fill(['description' => 'dasdssa']);
		$att->validate();
		//dd( $att->getAttributesArray());

		return \View::make($this->view());
	}


}
