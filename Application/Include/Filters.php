<?php

if (!defined('EG')) die('Direct access not allowed!');

class Filters
{
	public static $elements = array(
		"cerca"		=>	array(
			"type"	=>	"input",
			"attributes"	=>	array(
				"class"	=>	"form-control",
				"placeholder"	=>	"cerca",
			),
			"wrap"	=>	array('<div class="form-group pull-right">',""),
		),
		"attivo"		=>	array(
			"type"	=>	"select",
			"options"	=>	array("aa","bb"),
			"attributes"	=>	array(
				"class"	=>	"form-control",
			),
		),
	);
	
	public static function getAttributes($element)
	{
		$attributes = "";
		
		if (isset(self::$elements[$element]["attributes"]) and is_array(self::$elements[$element]["attributes"]))
		{
			foreach (self::$elements[$element]["attributes"] as $key => $value)
			{
				$attributes .= " $key = '$value' ";
			}
		}
		
		return $attributes;
	}
}
