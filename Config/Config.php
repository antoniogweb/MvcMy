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

include_once(ROOT."/config.php");

/*database parameters*/
define('DB', $dbName);
define('USER', $dbUser);
define('PWD', $dbPsw);
define('HOST', $dbHost);

/*default controller name*/
define('DEFAULT_CONTROLLER','utenti');

/*default action*/
define('DEFAULT_ACTION','login');

if (!isset($dominiPermessi))
	$dominiPermessi = array(
		"$domainName" => "$domainName",
	);

if (isset($_SERVER["SERVER_NAME"]) and isset($dominiPermessi[$_SERVER["SERVER_NAME"]]))
{
	define('DOMAIN_NAME', $dominiPermessi[$_SERVER["SERVER_NAME"]]);
}
else
{
	define('DOMAIN_NAME', $domainName);
}

/*website parameters*/



/*type of database.*/
//it can be: Mysql, Mysqli, PDOMysql, PDOMssql or None (first letter in uppercase)
define('DATABASE_TYPE','PDOMysql');

/*error controller*/
/*if you set ERROR_CONTROLLER to false, than MvcMyLibrary will set ERROR_CONTROLLER equal to DEFAULT_CONTROLLER*/
define('ERROR_CONTROLLER','panel');

/*error action*/
/*if you set ERROR_ACTION to false, than MvcMyLibrary will set ERROR_ACTION equal to DEFAULT_ACTION*/
define('ERROR_ACTION','main');

/*charset*/
// set the charset used by all the functions that manage multi byte strings (mb_string functions, htmlentitites, etc)
// the database connection will be set to the chosen charset too
// charsets allowed: 'UTF-8','ISO-8859-1','EUC-JP','SJIS'
define('DEFAULT_CHARSET','UTF-8');

/*rewrite settings*/
//set MOD_REWRITE_MODULE to true if you have installed the mod_rewrite module of the server, otherwise MOD_REWRITE_MODULE to false
define('MOD_REWRITE_MODULE',true);

//define if it has to use the new or the old style of the where clause definition (new style suggested!!)
define('NEW_WHERE_CLAUSE_STYLE',true);
