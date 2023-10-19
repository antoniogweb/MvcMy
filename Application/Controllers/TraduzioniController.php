<?php

if (!defined('EG')) die('Direct access not allowed!');

class TraduzioniController extends BaseController {
	
	public $argKeys = array();
	
	function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->s["admin"]->check("Admin");
	}

	public function form($queryType = 'insert', $id = 0)
	{
		$this->m[$this->modelName]->setValuesFromPost('valore');
		
		parent::form($queryType, $id);
	}
	
}
