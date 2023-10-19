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

class UtentipermessiModel extends GenericModel
{
	public $clinica = false;
	
	public function __construct() {
		$this->_tables='utenti_permessi';
		$this->_idFields='id_utente_permesso';
		
		$this->_lang = 'It';
		$this->_idOrder = 'ordine';
		
		parent::__construct();
	}
	
	public function del($id = null, $whereClause = null)
	{
		if (isset($id))
		{
			$clean['id'] = (int)$id;
			
			$record = $this->clear()->where(array("id_utente_permesso"=>$clean['id']))->record();
			
			$this->restore();
		}
		
		if (parent::del($id, $whereClause))
		{
			if (isset($id))
			{
				$clean["id_utente"] = (int)$record["id_utente"];
			}
			
			return true;
		}
	}
	
	public function insert()
	{
		$clean["id_utente"] = (int)$this->values["id_utente"];
		$clean["id_permesso"] = (int)$this->values["id_permesso"];

// 		$ng = $this->clear()->from("permessi")->select("*")->where(array("permessi.id_permesso"=>$clean["id_permesso"]))->rowNumber();
		
		$permessi = new PermessiModel();
		$record = $permessi->selectId($clean["id_permesso"]);
		
// 		print_r($record);
		
		$numero = $this->clear()->where(array("id_utente"=>$clean["id_utente"]))->rowNumber();
		
		if ($numero > 0)
		{
			$this->notice = "<div class='alert alert-danger'>Non è possibile associare più di un livello di accesso ad un utente.</div>";
			
			return false;
		}
		
		if (!empty($record))
		{
			$res3 = $this->clear()->where(array("id_permesso"=>$clean["id_permesso"],"id_utente"=>$clean["id_utente"]))->send();
			
			if (count($res3) > 0)
			{
				$this->notice = "<div class='alert alert-danger'>Questo permesso è già stato associato </div>";
			}
			else
			{
				$ngu = $this->select("*")->where(array("id_utente"=>$clean["id_utente"]))->rowNumber();
				
// 				if ($ngu === 0)
// 				{
					$res = parent::insert();
					
					if ($res)
					{
						return true;
					}
// 				}
// 				else
// 				{
// 					$this->notice = "<div class='alert'>Un utente non può essere associato a più di un gruppo.</div>";
// 				}
			}
		}
		else
		{
			$this->notice = "<div class='alert alert-danger'>Questo elemento non esiste o non è accessibile</div>";
		}
	}
	
}
