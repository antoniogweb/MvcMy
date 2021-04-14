<?php

if (!defined('EG')) die('Direct access not allowed!');

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

Params::$rewriteStatusVariables = false;

class ScaffoldController extends Controller {

	public function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->load('header');
		$this->load('footer','last');
		
		$this->modelName = "PagineModel";
		$this->model();
		
		$this->setArgKeys(array('page:forceNat'=>1, "cerca:sanitizeAll" => "tutti", "attivo:sanitizeAll" => "tutti"));
		
		$this->session('admin');
		$this->s['admin']->check();
		
		Params::$nullQueryValue = "tutti";
	}
	
	public function main()
	{
		$this->shift();
		
		$filters = array("attivo","cerca");
		
		$view = $this->m[$this->modelName]->select("
			id_pagine as __ID__,
			titolo as 'Titolo|strtolower|ucfirst',
			immagine as Immagine
		")->where(array(
			"lk"	=>	array("immagine"=>$this->viewArgs["cerca"]),
		))->process()->page($this->viewArgs["page"],2)->send(false);
		
		$this->append(array(
			"view"	=>	$view,
			"currentPage"		=>	$this->viewArgs["page"],
			"numberOfPages"		=>	$this->m[$this->modelName]->numberOfPages,
			"numberOfRecords"	=>	$this->m[$this->modelName]->numberOfRecords,
			"recordsPerPage"	=>	$this->m[$this->modelName]->recordsPerPage,
			"filters"			=>	$filters,
			"bulkActions"		=>	array("" => "Seleziona","del" => "Elimina selezionati"),
		));
		
		$this->load("main");
	}
	
	public function form($id = 0)
	{
		$this->shift(1);
		
		$this->m[$this->modelName]->setId($id);
		
		$this->m[$this->modelName]->setForm();
		$form = $this->m[$this->modelName]->renderForm("titolo,immagine");
		
		$this->append(array(
			"form"	=>	$form,
		));
		
		$this->load("form");
	}
	
}
