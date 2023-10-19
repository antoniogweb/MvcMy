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

class RevisioniModel extends GenericModel
{
	public function __construct() {
		$this->_tables = 'revisioni';
		$this->_idFields = 'id_revisione';
		
		$this->campoTitolo = "tabella";
		
		parent::__construct();
	}
	
	public function link($record)
	{
		$model = new $record["revisioni"]["model"];
		$recordElemento = $model->selectId($record["revisioni"]["id_tabella"]);
		
		$linkIdRevisione = "?lid=".$record["revisioni"]["id_revisione"];
		
		if (empty($recordElemento))
			return "";
		
		$url = Url::getRoot("panel/main");
		
// 		switch ($record["revisioni"]["tabella"])
// 		{
// 			
// 			default:
// 				$url = Url::getRoot("panel/main");
// 				break;
// 		}
		
		return $url.$linkIdRevisione;
	}
	
	public function icona($record)
	{
		
		
		return "folder";
	}
	
	public function tabella($record)
	{
		$ru = new RevisioniutentiModel();
		$ru->segnaLetta($record["revisioni"]["id_revisione"]);
		
		$model = new $record["revisioni"]["model"];
		$recordElemento = $model->selectId($record["revisioni"]["id_tabella"]);
		
		if (empty($recordElemento))
			return "";
		
// 		switch ($record["revisioni"]["tabella"])
// 		{
// 			
// 		}
		
		return $record["revisioni"]["tabella"];
	}
	
	public function edit($record)
	{
		$ru = new RevisioniutentiModel();
		$ru->segnaLetta($record["revisioni"]["id_revisione"]);
		
		return '<a class="iframe action_iframe" href="'.Url::getRoot().'revisioni/form/update/'.$record["revisioni"]["id_revisione"].'?partial=Y&nobuttons=Y">'.$record["revisioni"]["descrizione"].'</a>';
	}
	
	public function utente($record)
	{
		return "<a target='_blank' href='".Url::getRoot("utenti/form/update/".$record["revisioni"]["id_utente"])."'>".$record["revisioni"]["nome_utente"]." (ID UTENTE: ".$record["revisioni"]["id_utente"].")</a>";
	}
	
	public function successiva($id)
	{
		$record = $this->selectId((int)$id);
		
		if (!empty($record))
		{
			$res = $this->clear()->where(array(
				"id_tabella"	=>	(int)$record["id_tabella"],
				"tabella"		=>	sanitizeDb($record["tabella"]),
				"gt"			=>	array(
					"id_revisione"	=>	(int)$record["id_revisione"],
				),
			))->orderBy("id_revisione")->limit(1)->send(false);
			
			if (count($res) > 0)
				return json_decode($res[0]["json"],true);
			else
			{
				$model = new $record["model"];
				return $model->selectId($record["id_tabella"]);
			}
		}
	}
	
	public static function modifiche($precedende, $successiva, $model = null)
	{
		$differenze = array();
		
		foreach ($successiva as $k => $value)
		{
			if (!isset($precedende[$k]) || $precedende[$k] != $value)
			{
				if ($model && isset($model->campiMostraDifferenzeRevisioni))
				{
					$arrayCampi = explode(",",$model->campiMostraDifferenzeRevisioni);
					
					if (!in_array($k, $arrayCampi))
						continue;
				}
				
				$valorePrecedente = isset($precedende[$k]) ? $precedende[$k] : "";
				
				if ($model && isset($model->arrayFunzioniSuDifferenze[$k]))
				{
					$value = call_user_func(array($model, $model->arrayFunzioniSuDifferenze[$k]),$value);
					
					if ($valorePrecedente)
						$valorePrecedente = call_user_func_array(array($model, $model->arrayFunzioniSuDifferenze[$k]),array($valorePrecedente,$precedende));
					else
						$valorePrecedente = "";
				}
				
				if ($model && isset($model->arrayLabelCampiRevisioni[$k]))
				{
					$k = $model->arrayLabelCampiRevisioni[$k];
				}
				
				$differenze[$k] = array(
					$valorePrecedente,
					$value,
				);
			}
		}
		
		return $differenze;
	}
	
	public function daleggere($count = false)
	{
		if (!User::$logged)
		{
			if ($count)
				return 0;
			
			return array();
		}
		
		$this->clear()
			->sWhere("id_revisione not in (select id_revisione from revisioni_utenti where id_utente = ".(int)User::$id.")")
			->where(array(
				"gte"	=>	array(
					"data_modifica"	=>	sanitizeDb(date("Y-m-d",strtotime(User::$data["data_creazione"]))),
				),
				"visibile"	=>	1,
				"tipo"	=>	App::$modulo,
				"ruolo_utente"	=>	"Cliente",
			));
		
		if ($count)
			return $this->rowNumber();
		
		$revisioni = $this->orderBy("id_revisione desc")->limit(6)->convert()->send();
		
		return $revisioni;
	}
}
