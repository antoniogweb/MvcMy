<?php

// MvcMy is a flexible and easy-to-use PHP MVC framework to use together with MvcMyLibrary
// Copyright (C) 2009 - 2023  Antonio Gallo (info@laboratoriolibero.com)
// See LICENSE.txt.
// 
// This file is part of MvcMy
// 
// MvcMy is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// MvcMy is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with MvcMy.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

class AccessiModel extends GenericModel
{
	public function __construct() {
		$this->_tables = 'accessi';
		$this->_idFields = 'id_accesso';
		
		parent::__construct();
	}
	
	public function salvaAccesso($id_utente)
	{
		$this->setValues(array(
			"ip"	=>	getIp(),
			"data"	=>	date("Y-m-d"),
			"ora"	=>	date("H:i:s"),
			"id_utente"	=>	$id_utente,
		));
		
		if (isset($_SERVER["HTTP_USER_AGENT"]))
		{
			$this->setValue("user_agent", $_SERVER["HTTP_USER_AGENT"]);
		}
		
		$this->insert();
	}
}
