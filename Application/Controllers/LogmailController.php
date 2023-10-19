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

class LogmailController extends BaseController
{
	public $setAttivaDisattivaBulkActions = false;
	
	public $argKeys = array();
	
	public $sezionePannello = "impostazioni";
	
	public $tabella = "Mail azienda";
	
	function __construct($model, $controller, $queryString, $application, $action) {
		
		$this->argKeys = array(
			'id_azienda:sanitizeAll'=>'tutti',
			'id_mp:sanitizeAll'=>'tutti',
		);
		
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->s["admin"]->check("Admin");
	}

	public function main()
	{
		$this->shift();
		
		$this->mainFields = array("data_creazione","log_email.titolo","oggetto","log_email.inviata_a","log_email.tipo","inviata");
		$this->mainHead = "Data,Titolo,Oggetto,Inviata a,Tipo,Inviata";
		
		$this->filters = array("cerca");
		
		$this->scaffoldParams = array('recordPerPage'=>50, 'mainMenu'=>'esporta');
		
		$this->queryActions = "";
		$this->mainButtons = "";
		$this->addBulkActions = false;
		$this->colProperties = array();
		
		$this->m[$this->modelName]->clear()
				->where(array(
					"lk" => array('oggetto' => $this->viewArgs['cerca']),
				))
				->orderBy("data_creazione desc")->convert()->save();
		
		parent::main();
	}

	public function form($queryType = 'insert', $id = 0)
	{
		$this->shift(2);
		
		$queryType = "update";
		$_GET["report"] = "Y";
		
		$fields = "titolo,oggetto,inviata_a,inviata_a_nome,testo,data_creazione";
		
		$this->m[$this->modelName]->setValuesFromPost($fields);
		
		parent::form($queryType, $id);
	}
}
