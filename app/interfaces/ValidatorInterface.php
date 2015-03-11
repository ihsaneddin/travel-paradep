<?php 
namespace interfaces;

interface ValidatorInterface 
{
	function rules();
	function validate();
	function getAttributesArray();
}