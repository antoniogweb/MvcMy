<?php

if (!defined('EG')) die('Direct access not allowed!');

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class CategoryController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');
		
		$this->model();
		$this->session('admin');

		
// 		echo date("Y-m-d H:i:s");
		
// 		$this->m['CategoryModel']->strongConditions['insert'] = array(
// 			'checkNotEmpty'		=>	'visibile,name',
// 			'+checkNotEmpty'	=>	'tick|devi accettare tutte le condizioni'
// 		);
		
// 		$this->m['CategoryModel']->addStrongCondition("update",'checkNotEmpty','visibile,name');
// 		$this->m['CategoryModel']->addStrongCondition("update",'checkNotEmpty','tick|devi accettare tutte le condizioni');
		
		$this->m['CategoryModel']->addStrongCondition("both",'checkNotEmpty','name,categoria');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkNotEmpty','tick');
		
// 		$this->m['CategoryModel']->addStrongCondition("insert",'checkNotEmpty','visibile,name');
// 		$this->m['CategoryModel']->addStrongCondition("insert",'checkNotEmpty','tick|devi accettare tutte le condizioni');
		
// 		$this->m['CategoryModel']->strongConditions['update'] = array(
// 			'checkNotEmpty'		=>	'visibile,name',
// 			'+checkNotEmpty'	=>	'tick|devi accettare tutte le condizioni'
// 		);

// 		$this->m['CategoryModel']->strongConditions['del'] = array(
// 			'checkNotEmpty'		=>	'confirm'
// 		);
		
// 		$this->m['CategoryModel']->addSoftCondition("both",'checkLength|5','name');
// 		$this->m['CategoryModel']->addSoftCondition("both",'checkEqual','name,categoria');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkIsoDate','name');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkIsNotStrings|aa','name');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkIsStrings|aa,bb','name');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkMatch|/aa/','name');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkDecimal|10,2','name');
		
// 		$this->m['CategoryModel']->addValuesCondition("both",'checkNumeric','categoria,css');
// 		$this->m['CategoryModel']->addValuesCondition("both",'checkIsoDate','data');
// 		$this->m['CategoryModel']->addStrongCondition("both",'checkNumeric','ppp');
		
// 		print_r($this->m['CategoryModel']->strongConditions);
		
// 		$this->m['CategoryModel']->softConditions['update'] = array(
// 			'checkLength|5'		=>	'meta_ita',
// 			'checkEqual'		=>	'categoria,css',
// 			'checkNumeric'		=>	'categoria,css'
// 		);
// 		
// 		$this->m['CategoryModel']->softConditions['insert'] = array(
// 			'checkLength|5'		=>	'meta_ita|il meta non deve essere pi&ugrave lungo di 5 caratteri!!',
// 			'checkEqual'		=>	'categoria,css',
// 			'checkNumeric'		=>	'categoria,css'
// 		);
		
		$this->m['CategoryModel']->addDatabaseCondition("both","checkUnique","name");
// 		$this->m['CategoryModel']->databaseConditions['insert'] = array('checkUnique'=>'name');
// 		$this->m['CategoryModel']->databaseConditions['update'] = array('checkUniqueCompl'=>'name');
		
// 		$this->m['CategoryModel']->addSoftCondition("both",'checkLength|5','name');
		
		$this->setArgKeys(array('page:forceNat'=>1,'name:sanitizeAll'=>'undef','meta_ita:sanitizeAll'=>'undef','token:sanitizeAll'=>'token'));
		
		$this->m['CategoryModel']->supplUpdateValues = array('immagine'=>time());

		Params::$actionArray = "GET";
// 		Params::$rewriteStatusVariables = false;
		Params::$setValuesConditionsFromDbTableStruct = true;
		Params::$automaticConversionToDbFormat = true;
		Params::$automaticConversionFromDbFormat = true;
		Params::$automaticallySetFormDefaultValues = true;
	}

	public function index() {
		
		$this->load("index");
		
	}

	public function main() {
		$this->shift();

// 		echo $this->currPage;

// 		echo Params::$htmlentititiesCharset;
		
		$this->s['admin']->check();
// 		if (!$this->s['admin']->checkCsrf($this->viewArgs['token'])) $this->redirect('panel/main',2,'wrong token');
		
		$this->loadScaffold('main',array('popup'=>true));
// 		$this->scaffold->setWhereQueryClause(array('name'=>$this->viewArgs['name'], "meta_ita"=>$this->viewArgs['meta_ita']));
		
// 		$this->scaffold->fields = "*";
// 		echo $this->viewArgs['name']."<br /><br />";
		
		$fields = '[[checkbox]];navigation.id_navigation;,CategoryModel.ntest|navigation.id_navigation,RAW:;navigation.name;,navigation.data,[[checkbox:1]];navigation.visibile;,[[input]];navigation.id_ordinamento;,navigation.meta_ita,fff';
		
// 		$this->scaffold->loadMain($fields,'navigation.id_navigation','edit,lmoveup,lmovedown,ldel');
// 		$this->scaffold->loadMain($fields,'navigation.id_navigation');
		$this->scaffold->loadView($fields);
		
// 		print_r($this->scaffold->model->foreignKeys);
		
// 		$this->scaffold->update('del,moveup,movedown');
		$this->scaffold->update('del');
		
		$this->scaffold->setHead('[[bulkselect:checkbox_navigation_id_navigation]],ID CAT,CAT,DATE,VISIB?,ORD,META ITA,FUNZIONE');
		
// 		$this->scaffold->itemList->setBulkActions(array(
// 			"input_navigation_id_ordinamento"	=>	array("ordinaAction","Conferma colonna ORDINAMENTO"),
// 			"checkbox_navigation_visibile"	=>	array("mostraAction","Conferma colonna VISIBILE"),
// 			"checkbox_navigation_id_navigation"	=>	array("eliminaAction","Elimina elementi selezionati (colonna SEL)","confirm"),
// 		));
		
// 		$this->scaffold->itemList->submitImageType = 'yes';
// 		$folder = $this->baseUrlSrc . '/Public/Img/';
// 		$this->scaffold->itemList->submitImages = array(
// 			'up'=>$folder.'Icons/elementary_2_5/up.png',
// 			'down'=>$folder.'Icons/elementary_2_5/down.png',
// 			'edit'=>$folder.'Icons/elementary_2_5/edit.png',
// 			'del'=>$folder.'Icons/elementary_2_5/delete.png'
// 		);
// 		$this->scaffold->itemList->addItem('Form','category/form/update',';navigation.id_navigation;','EDIT','updateAction','edit the record ;navigation:id_navigation;');
// 		$this->scaffold->itemList->addItem('link','category/form/insert','test title','INSERT:CIAO_;navigation.id_navigation;');

		$metaValues = $this->scaffold->model->getSelectArrayFromEnumField("meta_ita");
		$this->scaffold->itemList->setFilters(array(null,null,array('name','Cat: '),null,null,null,array("meta_ita",null,$metaValues)));
		$this->scaffold->model->convert();
		
// 		$this->scaffold->itemList->rowAttributes = array("class"=>"aa");
		
		$data['scaffold'] = $this->scaffold->render();
		
// 		echo $this->controller.'/'.$this->action;
// 		echo $this->currPage;
// 		echo $this->controller.'/'.$this->action;
// 		echo $this->currPage;
// 		var_dump($this->scaffold->model->queryResult);
		
// 		$this->m["CategoryModel"]->checkIfDelIsAllowed(null, "name='asdasd'");
// 		$this->m["CategoryModel"]->checkIfDelIsAllowed(1);
// 		echo $this->m["CategoryModel"]->notice;

		$this->set($data);
		$this->load('view');

	}

	public function form($queryType = "insert", $id = 0)
	{
		$this->shift(2);
		
		$clean["id"] = (int)$id;
		
		$this->m['CategoryModel']->setValuesFromPost('name,categoria');
		
		$this->m['CategoryModel']->setId($clean["id"]); //the method do a cast to int
		
// 		Params::$actionArray = "POST";
		
// 		print_r($_POST);
		
		$this->s['admin']->check();
		
		$this->m['CategoryModel']->updateTable('insert,update');
		
		print_r($this->m['CategoryModel']->errors);
		
		$this->loadScaffold('form');
		
// 		$this->scaffold->loadForm($queryType,"category/form/$queryType/".$clean["id"]);
		$this->scaffold->loadForm($queryType);
		
// 		$this->scaffold->setRecordId($clean["id"]);
// 		print_r($this->m['PagineModel']->values);
// 		$this->scaffold->model->sanitize();
		
// 		echo $this->m['PagineModel']->getQuery();
// 		echo $this->scaffold->model->lastId();

// 		$this->scaffold->form->setEntry('tick','Checkbox','1');
		//you can change the class of the label and the class of the entry of the form
// 		$this->scaffold->form->entry['tick']->entryClass = 'myclass';
// 		$this->scaffold->form->entry['tick']->labelClass = 'entryLabel';
// 		$this->scaffold->form->setEntry('visibile','Radio',array('visibile'=>'1','invisibile'=>'2'));
		
		$this->scaffold->getFormValues(array('sanitizeHtml','none'));
		$data['form'] = $this->scaffold->render();

		$this->append($data);
		$this->load('form');
		/*
// 		if (!$this->s['admin']->checkCsrf($this->viewArgs['token'])) $this->redirect('panel/main',2,'wrong token');
		$this->m['CategoryModel']->sanitize();
// 		$this->m['CategoryModel']->values["ppp"] = 1;
		$this->m['CategoryModel']->updateTable('insert,update');
// 		echo $this->m['CategoryModel']->getQuery();

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"category/form/$queryType");
		//set the name of the form
		$this->scaffold->form->name = 'name_casuale';
// 		$this->scaffold->update('insert,update');
// 		$this->scaffold->getFormValues('sanitizeHtml',null,array('meta_ita'=>'description','css'=>'blackground:'),array('name'=>'my_md5'));
		$this->scaffold->getFormValues('sanitizeHtml',null,array('css'=>'blackground:'));
		$this->scaffold->setFormEntries('model');
// 		$this->scaffold->setFormEntries('model',array('css'=>'password','categoria'=>'password'));
// 		$array = array('Di Antonio'=>'Antonio','Di Giulia'=>'Giulia','Di Fabiano'=>'Fabiano');
		$this->scaffold->form->setEntry('tick','Checkbox','1');
		//you can change the class of the label and the class of the entry of the form
// 		$this->scaffold->form->entry['tick']->entryClass = 'myclass';
		$this->scaffold->form->entry['tick']->labelClass = 'entryLabel';
		$this->scaffold->form->setEntry('visibile','Radio',array('visibile'=>'1','invisibile'=>'2'));
		
		$image = $this->baseUrl."/Public/Img/Icons/elementary_2_5/edit.png";
// 		$this->scaffold->form->submit = array(
// 				$queryType."Action"=> array("save",$queryType,$queryType,$image),
// 			);
		
// 		$struct = array(
// 			'formalità' => array('name','tick'),
// 			'altre info' => array('visibile','categoria','css','meta_ita','id_navigation','data','id_sx'),
// 		);
// 
// 		$data['form'] = $this->scaffold->render(null,$struct);

		$data['form'] = $this->scaffold->render();
		
// 		print_r($this->m['CategoryModel']->getConditions("database"));
		
// 		$a = &$this->m['CategoryModel']->getConditions("values");
// 		$a = array();
// 		print_r($this->m['CategoryModel']->getConditions("values"));
// 		$this->m['CategoryModel']->saveConditions("values");
// 		print_r($this->m['CategoryModel']->backupConditions["values"]);

// 		$this->m['CategoryModel']->saveConditions("values");
// 		$this->m['CategoryModel']->clearConditions("values");
// // 		$this->m['CategoryModel']->restoreConditions("values");
// 		print_r($this->m['CategoryModel']->getConditions("values"));
		
		$this->set($data);
		$this->load('form');*/
		
// 		print_r($this->m['CategoryModel']->db->queries);
	}

	public function query()
	{
// 		$this->m['CategoryModel']->from('pagine')->left('navigation')->right('sections')->on('pagine.id_navigation = navigation.id_navigation')->using('id_section')->send();
// 		$res = $this->m['CategoryModel']->clear()->selectId(147);
// 		echo $this->m['CategoryModel']->getQuery();
// 		print_r($res);

// 		$this->m['CategoryModel']->from('pagine')->left('navigation')->right('sections')->on('pagine.id_navigation = navigation.id_navigation')->using('id_section')->save()->clear()->restore()->send();
		
		$where = array(
		
			"OR" => array(
				"c" => 1,
				"b" => 2,
			),
		
		);
		
		$this->m['CategoryModel']->from('pagine')->left('navigation')->right('sectionsw')->on('pagine.id_navigation = navigation.id_navigation')->using('id_section')->where($where)->sWhere("t=1 AND test=2")->save()->clear()->toList("id_navigation")->send();
		
		echo $this->m['CategoryModel']->getError()."<br />";
		
		echo $this->m['CategoryModel']->getQuery() . "<br />";
		
		$this->m['CategoryModel']->restore()->send();
		
		echo $this->m['CategoryModel']->getQuery() . "<br />";
		
		$this->m['CategoryModel']->clear()->select("dd")->toList("id_navigation")->send();
		
		echo $this->m['CategoryModel']->getError()."<br />";
		
		echo "test";
	}
	
	public function checkdate()
	{
		var_dump(checkIsoDate("2015-02-29"));
		
// 		echo mktime(0, 0, 0, 1, 1, 2029);
	}
	
	public function types()
	{
// 		print_r($this->m["CategoryModel"]->db->getTypes("navigation","name,id_navigation,data,css,lista_pagine",true));
		
// 		print_r($this->m["CategoryModel"]->db->getDefaultValues("navigation","*",true,true));

		print_r($this->m["CategoryModel"]->db->getKeys("navigation","*",true,true));
	}
	
	public function misc()
	{
// 		var_dump(checkInteger("23"));
		
// 		var_dump(checkDecimal("10.23","4,2"));

// 		$this->m["Category	Model"]->db->describe("navigation");
		
// 		print_r($this->m["CategoryModel"]->query("DESCRIBE navigation"));

		$mysqli = Db_Mysqli::getInstance();
		$db = $mysqli->getDb();
		$a = "'";
		$sql = "select * from category where name = '". $db->real_escape_string($a)."'";
		echo $sql;
	}
	
	public function autoextract()
	{
		$res = $this->m["CategoryModel"]->select("navigation.*,pagine.*")->inner("pagine")->using("id_navigation")->orderBy("navigation.id_ordinamento")->send();
		
// 		print_r($res);
	}
	
	public function testinsert()
	{
		
		Params::$setValuesConditionsFromDbTableStruct = false;
		Params::$automaticConversionToDbFormat = false;
		Params::$automaticConversionFromDbFormat = false;
		Params::$automaticallySetFormDefaultValues = false;

		$this->m['CategoryModel']->values = array(
			'name'  	=>	"aa",
		);
		$this->m['CategoryModel']->insert();
		
// 		echo $this->m['CategoryModel']->notice;
		
	}
}
