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

Helper_List::$filtersFormLayout["submit"]["attributes"]["style"] = "margin-bottom: 10px;";

trait TraitRevisioniController
{
	public function main()
	{
		$this->shift();
		
		$this->scaffoldParams = array('recordPerPage'=>50, 'mainMenu'=>'esporta');
		
		$this->mainFields = array("revisioni.descrizione", "revisioni.azione", "tabella", "utente", "revisioni.data_modifica");
		$this->mainHead = "Descrizione,Azione,Elemento,Utente,Data";
		
		$filtroTabella = array(
			"tutti"			=>	"Tipo di modifica",
		);
		
		$this->filters = array("dal","al","cerca");
		
		$orderBy = "id_revisione desc";
		
		
		$this->m[$this->modelName]->clear()
				->where(array(
					"visibile"	=>	1,
					"lk"	=>	array(
						"descrizione"	=>	$this->viewArgs["cerca"],
					),
					" lk"	=>	array(
						"tabella"	=>	$this->viewArgs["tabella"],
					),
					"gte"	=>	array("data_modifica"	=>	reverseDataSlash($this->viewArgs["dal"])),
					"lte"	=>	array("data_modifica"	=>	reverseDataSlash($this->viewArgs["al"])),
					"tipo"	=>	App::$modulo,
					"ruolo_utente"	=>	"Cliente",
				))
				->orderBy($orderBy)->convert()->save();
		
		parent::main();
	}
	
	public function form($queryType = 'insert', $id = 0)
	{
		$this->menuLinks = "back";
		
		$_GET["report"] = "Y";
		
		$this->m[$this->modelName]->setValuesFromPost('descrizione,json');
		
		parent::form($queryType, $id);
		
		if ($queryType == "update")
		{
			$precedente = $this->m["RevisioniModel"]->selectId((int)$id);
			
			if (empty($precedente))
				$this->redirect("");
			
			$record = array("revisioni"=>$precedente);
			$data["link_elemento"] = $this->m["RevisioniModel"]->link($record);
			
			$successiva = $this->m["RevisioniModel"]->successiva((int)$id);
			
			$data["differenze"] = $this->m["RevisioniModel"]->modifiche(json_decode($precedente["json"], true), $successiva, new $precedente["model"]);
			
			$this->append($data);
		}
	}
}
