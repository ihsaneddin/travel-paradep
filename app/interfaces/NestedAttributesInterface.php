<?php 
namespace interfaces;

interface NestedAttributesInterface 
{	
	public function nestSave($data);

	function setAttributes($data);

	function setChildObject($relation, $data);

	function childPrimaryKey($relation);
}