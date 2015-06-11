<?php

function current_user()
{
	return Confide::user();
}


function input_value($original,$edited)
{
	$value = $edited;
	if (empty($edited))
	{
		$value = $original;
	}
	return $value;
}

function empty_table($empty, $column=6, $message = 'No record found!')
{
	if ($empty) return '<tr class="no-record"><td colspan="'.$column.'" class="error-validation-message"><center>'.$message.'</center></td></tr>';
}

function merge_date_and_hour($date,$hour)
{
	if (!empty($date) && !empty($hour))
	{
		try {
			return DateTime::createFromFormat('j M Y H:i', $date.' '.$hour);
		}catch (Exception $e)
		{
			return 'Invalid date or time';
		}
	}
	return null;
}

function format_date_time($date_string, $format = 'Y/m/d H:i:s')
{
	try {
		if (!empty($date_string))
		{
			$date= new DateTime($date_string);
			return date_format($date,$format);
		}
	}catch (Exception $e)
	{
		return null;
	}
}

function has_access_to($route, Array $transition = array())
{
	$accessable = false;
	return $accessable;
}

function carbon_format($format=null, $time=null)
{
	if (is_null($time) || is_null($format))
	{
		return Carbon::now();
	}
	return Carbon::createFromFormat($format, $time);
}