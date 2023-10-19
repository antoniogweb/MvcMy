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

class ImpostazioniModel extends GenericModel {

	public static $valori;
	
	public function __construct() {
		$this->_tables='impostazioni';
		$this->_idFields='id_imp';

// 		$this->_idOrder = 'id_order';
		$this->_lang = 'It';
		
		parent::__construct();
		
	}
	
	public function getImpostazioni()
	{
		$res = $this->send();
		
		if (count($res) > 0)
		{
			self::$valori = htmlentitydecodeDeep($res[0]["impostazioni"]);
		}
	}

}
