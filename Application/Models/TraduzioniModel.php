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

class TraduzioniModel extends GenericModel {
	
	public function __construct() {
		$this->_tables='traduzioni';
		$this->_idFields='id_t';
		
		parent::__construct();
	}
	
	public function ottieniTraduzioni()
	{
		$values = $this->clear()->where(array(
			"lingua"		=>	sanitizeAll(Lang::$current),
		))->toList("chiave", "valore")->send();
		
		Lang::$i18n[Lang::$current] = $values;
	}
	
	public function getTraduzione($chiave, $function = "none")
	{
		$res = $this->clear()->where(array(
				"chiave"		=>	sanitizeDb($chiave),
				"lingua"		=>	sanitizeAll(Lang::$current),
			))->record();
			
		if (count($res) > 0)
		{
			$valore = call_user_func($function,$res["valore"]);
			return "<span class='blocco_traduzione'>".$valore."<i data-id='".$res["id_t"]."' class='fa fa-edit text text-success edit_traduzione'></i><span>";
		}
		
		return "";
	}
	
}
