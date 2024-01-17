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

class ImpostazioniController extends BaseController
{
	public $setAttivaDisattivaBulkActions = false;
	
	public $argKeys = array();
	
	public $sezionePannello = "impostazioni";
	
	function __construct($model, $controller, $queryString, $application, $action) {
		
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->s["admin"]->check("Admin");
	}

	public function form($queryType = 'insert', $id = 0)
	{
		$this->menuLinks = "save";
		
		$this->m[$this->modelName]->setValuesFromPost('smtp_from,smtp_nome,bcc,smtp_host,smtp_port,smtp_user,smtp_psw');
		
		parent::form($queryType, $id);
	}
	
	public function thumb($field = "", $id = 0)
	{
		parent::thumb($field, $id);
	}
}
