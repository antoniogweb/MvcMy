<?php 

// EasyGiant is a PHP framework for creating and managing dynamic content
//
// Copyright (C) 2009 - 2020  Antonio Gallo (info@laboratoriolibero.com)
// See COPYRIGHT.txt and LICENSE.txt.
//
// This file is part of EasyGiant
//
// EasyGiant is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// EasyGiant is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with EasyGiant.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

class Route
{

	//application,controller,action or controller,action couples that can be reached by the browser
	//set 'all' if you want that all the application,controller,action or controller,action couples can be reached by the browser
	public static $allowed = array(
	
// 		'panel,main',
// 		'category,main',
// 		'test,articles,index',
// 		'test2,articles,index',
		'all'
	
	);
	
	//it can be 'yes' or 'no'
	//set $rewrite to 'yes' if you want that EasyGiant rewrites the URLs according to what specified in $map
	public static $rewrite = 'yes';
	
	//define the urls of your website
	//you have to set $rewrite to 'yes'
	public static $map = array(
		'panel'	=>	'panel/main',
		'mytest'=>	'category/main',
	);

}
