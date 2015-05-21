<?php


function input_value($original,$edited)
{
	$value = $edited;
	if (empty($edited))
	{
		$value = $original;
	}
	return $value;
}