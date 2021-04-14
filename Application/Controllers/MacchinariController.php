<?php

if (!defined('EG')) die('Direct access not allowed!');

class MacchinariController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		
		Params::$rewriteStatusVariables = false;
		
		$this->model();

		Params::$actionArray = "GET";
		
		$this->setArgKeys(array("cerca:sanitizeAll" => ""));
// 		$this->load("header");
// 		$this->load("footer","last");
	}

	public function main()
	{
		$this->shift();
		
		$this->m["MacchinariModel"]->updateTable("del");
		
		$this->m["MacchinariModel"]->where(array(
			"lk"	=>	array("titolo"	=>	$this->viewArgs["cerca"]),
		));
		
		$this->loadScaffold();
		
		$this->scaffold->loadView("macchinari.titolo","ledit,ldel");
		
		$this->scaffold->setHead("Titolo");
		
		$this->scaffold->itemList->setFilters(array("cerca"));
		
		$this->scaffold->render();
		
		$data["main"] = $this->scaffold->html["main"];
		$data["menu"] = $this->scaffold->html["menu"];
		$data["pageList"] = $this->scaffold->html["pageList"];
		$data["notice"] = $this->m["MacchinariModel"]->notice;
		
		$this->append($data);
		
		$this->load("main");
	}

	public function form($queryType = "insert", $id = 0)
	{
		$this->shift(2);
		
		$clean["id"] = (int)$id;
		
		$this->m["MacchinariModel"]->setId($clean["id"]);
		
		$this->m["MacchinariModel"]->setValuesFromPost("titolo,attivo,descrizione");
		
		$this->m["MacchinariModel"]->addValuesCondition("both","checkNotEmpty","titolo");
		
		$this->m["MacchinariModel"]->updateTable("insert,update");
		
		$this->m["MacchinariModel"]->convert();
		
		$this->loadScaffold("form");
		
		$this->scaffold->loadForm($queryType);
		
		$this->scaffold->getFormValues();
		
		$data["html"] = $this->scaffold->render();
		
		echo $data["html"];
	}

}