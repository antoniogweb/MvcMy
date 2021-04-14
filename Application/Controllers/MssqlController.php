<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

Params::$setValuesConditionsFromDbTableStruct = true;

class MssqlController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->helper('Array');
		$this->model("MaterietipoModel");
		$this->session('admin');
	}

	public function index()
	{
		$this->clean();
// 		$this->m["MaterietipoModel"]->query('insert into MaterieTipo (Nome,Descrizione) values ("aa","bb")');
		
// 		$this->m['MaterietipoModel']->addSoftCondition("both",'checkLength|5','Nome');
// 		
// 		$this->m["MaterietipoModel"]->setValues(array(
// 			"Nome"	=>	"55",
// 			"Descrizione"	=>	"55",
// 		));
// // 		die();
// 		$this->m["MaterietipoModel"]->db->beginTransaction();
// 		$this->m["MaterietipoModel"]->insert();
// 		echo $this->m["MaterietipoModel"]->notice;
// 		$this->m["MaterietipoModel"]->db->commit();
		
		$record = $this->m["MaterietipoModel"]->select("[MaterieTipo],Nome as MaterieTipo___AA")->send(true);
		print_r($record);
// 		echo "ciao";
		
// 		$this->m["MaterietipoModel"]->getTableFieldsInQuery();
		
	}
}
