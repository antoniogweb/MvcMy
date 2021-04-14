<?php

Params::$setValuesConditionsFromDbTableStruct = true;
Params::$automaticConversionToDbFormat = true;
Params::$automaticConversionFromDbFormat = true;
Params::$automaticallySetFormDefaultValues = true;

class Test3Controller extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		
		$this->model("PagesModel");
		
		$this->load('layout');
// 		$this->load('footer','last');
		
	}
	
	public function index()
	{
		$this->m["PagesModel"]->values = array(
			"title"			=>	"ciao",
			"principale"	=>	"N",
		);
		
		$this->m["PagesModel"]->sanitize();
		
		
		if ($this->m["PagesModel"]->insert())
		{
			
		}
		
		$data["query"] = $this->m["PagesModel"]->getQuery();
		$data["notice"] = $this->m["PagesModel"]->notice;
		
		$this->append($data);
// 		print_r($this->m["PagesModel"]->db->queries);

	}
	
}