<?php

if (!defined('EG')) die('Direct access not allowed!');

class PanelController extends BaseController {

	public function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);
		$this->session('admin');

// 		$this->s['admin']->check();
	}
	
	public function main($tipo = "sito")
	{
		$this->shift();
		
		switch ($tipo)
		{
			case "gestionale":
				$data["sezionePannello"] = "gestionale";
				break;
			case "impostazioni":
				$data["sezionePannello"] = "impostazioni";
				break;
			default:
				$data["sezionePannello"] = "gestionale";
				break;
		}

		$data['tm'] = $this->_topMenuClasses;
		
		Params::$nullQueryValue = $this->nullQueryValue;
		
// 		print_r($data["aziende"]);
		$this->append($data);

		$this->load('panel');
	}
	
}
