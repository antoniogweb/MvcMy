<?php

if (!defined('EG')) die('Direct access not allowed!');

Helper_List::$filtersFormLayout["submit"]["attributes"]["style"] = "margin-bottom: 10px;";

class RevisioniController extends BaseController
{
	use TraitRevisioniController;
	
	function __construct($model, $controller, $queryString, $application, $action) {
		
		$this->setAttivaDisattivaBulkActions = false;
		
		$this->sezionePannello = "impostazioni";
		
		$this->argKeys = array(
			'tabella:sanitizeAll'=>'tutti',
			'dal:sanitizeAll'=>'tutti',
			'al:sanitizeAll'=>'tutti',
			'id_azienda:sanitizeAll'=>'tutti',
			'ordineazienda:sanitizeAll'=>'tutti',
		);
		
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->s["admin"]->check("Admin");
	}
}
