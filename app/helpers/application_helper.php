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

function empty_table($empty, $column=6, $message = 'No record found!')
{
	if ($empty) return '<tr><td colspan="'.$column.'" class="error-validation-message"><center>'.$message.'</center></td></tr>';
}

function merge_date_and_hour($date,$hour)
{
	//dump(Input::all());
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