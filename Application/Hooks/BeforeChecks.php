<?php

// EasyGiant is a PHP framework for creating and managing dynamic content
//
// Copyright (C) 2009 - 2014  Antonio Gallo (info@laboratoriolibero.com)
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

//in this file you can write the PHP code that will be executed at the beginning of the EasyGiant execution, before super global array have been sanitizied

//this is the preferred place to create and fill log files

//you can access the whole set of classes and functions of EasyGiant

// Params::$htmlentititiesCharset = "UTF-8";
Params::$nullQueryValue = 'undef';
Params::$installed = array("test","test2");

Params::$valuesConditionsFromFormatsOfFieldsNames = array(
	
	"/^(.*?)\_$/i"	=>	"checkNotEmpty",
	
);

Users_CheckAdmin::$usersModel = "UsersModel";
Users_CheckAdmin::$groupsModel = "GroupsModel";
Users_CheckAdmin::$sessionsModel = "AdminsessionsModel";
Users_CheckAdmin::$accessesModel = "AccessesModel";

Params::$frontEndLanguages = array("it","en");

Params::$defaultSanitizeFunction = "sanitizeDb";

Params::$defaultSanitizeHtmlFunction = "sanitizeHtml";

Params::$newWhereClauseStyle = true;

function MyLog()
{
	$ip = getIp();
	
	Files_Log::$logFolder = ROOT.'/Logs';
	Files_Log::$logExtension = '.log';
	Files_Log::$logPermission = 0777;

	$string = null;
	foreach ($_POST as $key => $value)
	{
		$string .= $key.":".$value."\t";
	}

	$logFile = Files_Log::getInstance('where');
	$logFile->writeString("IP:$ip\tURI:\t".$_SERVER['REQUEST_URI']."\tPOST\t".$string);
}

// Mylog();
