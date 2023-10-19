<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

if (!defined('EG')) die('Direct access not allowed!');

class Route
{
	//controller,action couples that can be reached by the browser
	//set 'all' if you want that all the controller,action couples can be reached by the browser
	public static $allowed = array(
		'panel,main',
		'utenti,login',
		'utenti,logout',
		'utenti,main',
		'utenti,form',
		'utenti,permessi',

		'password,form',

		'upload,main',
		'upload,thumb',
		
		'traduzioni,form',
		
		'impostazioni,form',
		
		'revisioni,main',
		'revisioni,form',
		
		'logmail,main',
		'logmail,form',
	);

	//it can be 'yes' or 'no'
	//set $rewrite to 'yes' if you want that EasyGiant rewrites the URLs according to what specified in $map
	public static $rewrite = 'no';

	//define the urls of your website
	//you have to set $rewrite to 'yes'
	public static $map = array();
}
