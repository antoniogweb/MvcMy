<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PagineController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->helper('Array');
		$this->model();
		$this->session('admin');
		$this->m['PagineModel']->setFields('name,id_navigation,titolo,html','sanitizeAll');
// 		$this->m['PagineModel']->validateConditions['insert'] = 'checkLength|10:titolo;';
// 		$this->m['PagineModel']->validateConditions['update'] = 'checkLength|10:titolo;';
		
		$this->m['PagineModel']->strongConditions['update'] = array(
// 			'+checkAlphaNum'	=>	'name',
			'checkNotEmpty'		=>	'id_navigation'
		);

		$this->m['PagineModel']->strongConditions['insert'] = array(
// 			'checkAlphaNum'	=>	'name',
// 			'checkNotEmpty'	=>	'id_navigation'
		);

		$this->m['PagineModel']->softConditions['update'] = array(
// 			'checkIsStrings|pagina1,1,2'	=>	'titolo',
			'checkIsNotStrings|undef'		=>	'name',
			'checkIsNotStrings|my'			=>	'name'
		);

		$this->m['PagineModel']->softConditions['insert'] = array(
// 			'checkIsStrings|pagina1,1,2'	=>	'titolo',
			'checkIsNotStrings|undef'		=>	'name',
			'checkIsNotStrings|my'			=>	'name'
		);
		
		$this->setArgKeys(array('page:forceNat'=>1,'value:sanitizeAll'=>'undef'));
		
		Form_Form::$defaultEntryAttributes["className"] = "test_class";
	}

	public function index() {
		echo '<h2>It works!!</h2>';
	}

	public function main() {
		
		$this->shift();
		
		$this->s['admin']->check();

		Params::$nullQueryValue = 'undef';
		
// 		echo $this->m['PagineModel']->db->charset;
// 		echo var_dump($this->m['PagineModel']->db->charsetError);
		
		$params = array('popup'=>true,'recordPerPage'=>40);
		
// 		echo $this->viewArgs['value'];
		$this->loadScaffold('main',$params);
		$this->scaffold->setWhereQueryClause(array('-id_navigation'=>$this->viewArgs['value']));
// 		print_r($this->scaffold->model->getWhereQueryClause());
		$this->scaffold->loadMain('pagine:id_pagine,pagine:name,navigation:name,navigation.data','pagine:id_pagine','moveup,movedown,edit,del');
		$this->scaffold->setHead('ID,NOME DELLA PAGINA,NOME DELLA CATEGORIA,DATA CATEGORIA');
		$this->scaffold->update('del,moveup,movedown');
		$this->scaffold->fields = 'pagine.*,navigation.*';
		$this->scaffold->pageList->nextString = ">>";
		$this->scaffold->pageList->previousString = "<<";

		$this->scaffold->itemList->colProperties = array(
			array(
				'class'	=>	'ciao',
				'width'	=>	'100px',
				'style'	=>	'background-color:orange;',
			),
		);
		$this->scaffold->model->from('pagine')->inner('navigation')->using('id_navigation')->convert();
		$this->scaffold->render();
// 		echo $this->scaffold->model->getQuery();
		
		$data['menù'] = $this->scaffold->html['menu'];
		$data['main'] = $this->scaffold->html['main'];
		$data['pageList'] = $this->scaffold->html['pageList'];
// 		$data['popup'] = $this->scaffold->html['popup'];
		$data['notice'] = $this->scaffold->model->notice;
		
		$data['popup'] = $this->m['PagineModel']->select('navigation.*')->toList('navigation.name','navigation.id_navigation')->where(array())->send();
		
		$this->set($data);
		$this->load('main');
		
// 		print_r($this->m["PagineModel"]->db->getTypes("navigation","lista_pagine"));

	}

	public function form($queryType) {
		Params::$setValuesConditionsFromDbTableStruct = true;
		Params::$automaticConversionToDbFormat = true;
		Params::$automaticConversionFromDbFormat = true;
		Params::$automaticallySetFormDefaultValues = true;
		
		$this->shift(1);

		$this->s['admin']->check();

		$this->loadScaffold('form');
		$this->scaffold->model->fields .= ',immagine';
		$this->scaffold->model->fields .= ',bo';
		$this->scaffold->loadForm($queryType,"pagine/form/$queryType");
// 		print_r($this->m['PagineModel']->values);
// 		$this->scaffold->model->sanitize();
		$this->m['PagineModel']->updateTable('insert,update');
// 		echo $this->m['PagineModel']->getQuery();
// 		echo $this->scaffold->model->lastId();
		$this->scaffold->getFormValues(array('sanitizeHtml','none'));
		$data['form'] = $this->scaffold->render();

		$this->set($data);
		$this->load('form');
	}

	public function test()
	{
		$this->m['PagineModel']->setWhereQueryClause(array('id_pagine' => '>50'));
// 		$this->m['PagineModel']->appendWhereQueryClause(array('id_pagine' => 3));
		$table = $this->m['PagineModel']->getAll();
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}

	public function query()
	{
		$table = $this->m['PagineModel']->db->select('pagine','*');
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}

	public function del()
	{
		$this->m['PagineModel']->db->del('pagine','id_pagine=24');
		echo $this->m['PagineModel']->getQuery();
		echo $this->m['PagineModel']->notice;
		var_dump($this->m['PagineModel']->result);
	}
	
	public function query2()
	{
		$this->m['PagineModel']->orderBy = 'pagine.id_pagine desc';
// 		$this->m['PagineModel']->limit = '10,2';
		$this->m['PagineModel']->setWhereQueryClause(array('id_pagine'=>'not in(53,63)'));
		$table = $this->m['PagineModel']->getAll('');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}

	public function fields()
	{
		$this->m['PagineModel']->setWhereQueryClause(array('-name'=>'qwe','name'=>'prima'));
// 		$table = $this->m['PagineModel']->getFields('pagine.name','pagine','');
		$table = $this->m['PagineModel']->getFields('pagine.name');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo 'ciao';
	}

	public function neighbours()
	{
		$this->m['PagineModel']->setWhereQueryClause(array('id_pagine'=>'78','id_navigation'=>109));
		
		$table = $this->m['PagineModel']->getNeighbours('id_pagine','pagine.name,pagine.id_pagine');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';

		$table = $this->m['PagineModel']->where(array('id_pagine'=>'78','id_navigation'=>109))->getNeighbours('id_pagine','pagine.name,pagine.id_pagine');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo 'ciao';
	}
	
	public function recursive()
	{
		$this->m['PagineModel']->logicalOperators = array('OR');
		
// 		$queryClause = array(
// 			'name'		=>	'prima',
// 			'OR'		=>	array(
// 								'id_pagine'	=>	'70',
// 								'-name'		=>	'qwe',
// 								'asd'		=>	1,
// 								'OR'	=>	array(
// 													'id_pagine'	=>	'70',
// 													'-name'		=>	'rrr',
// 													'asd'		=>	'undef'
// 												)
// 							)
// 		);

		$queryClause = array(
			'OR'	=>	array(
						'id_pagine'	=>	'!=70',
						'-name'		=>	'qwe',
						'asd'		=>	1,
						'AND'	=>	array(
											'id_pagine'	=>	'70',
											'-name'		=>	'rrr',
											'asd'		=>	'undef'
										)
					),
			'AND'	=>	array(
						'id_pagine'	=>	'70',
						'OR'	=>  array(
											'id_pagine'	=>	'like="70"',
											'-id_navigation'	=>	'rrr',
											'asd'		=>	'undef'
										)
					),
			'+OR'	=>	array(
						'id_pagine'	=>	'70',
						'OR'	=>  array(
											'id_pagine'	=>	'70',
											'-name'		=>	'rrr',
											'asd'		=>	'undef'
										)
					)
		);
		
		$this->m['PagineModel']->setWhereQueryClause($queryClause);
		$table = $this->m['PagineModel']->getFields('pagine.name');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo 'ciao';
	}

	public function testdate()
	{
		$queryClause = array('n!dayofmonth(pagine.time)'=>'16');
		$this->m['PagineModel']->setWhereQueryClause($queryClause);
		$table = $this->m['PagineModel']->getFields('pagine.name as nome,dayofmonth(pagine.time) as time');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}
	
	public function queryerror()
	{
		$this->m['PagineModel']->getFields('pagine.iname as nome,dayofmonth(pagine.time) as time');
		echo $this->m['PagineModel']->db->getErrno().'<br />';
		echo $this->m['PagineModel']->db->getError().'<br />';
	}

	public function testinclude()
	{
		$this->m['PagineModel']->clearFields();
		$this->m['PagineModel']->values['name'] = 'cazzo';
		$this->m['PagineModel']->update(86);
		echo $this->m['PagineModel']->getQuery();
	}

	public function dynamicquery()
	{
// 		$table = $this->m['PagineModel']->select('pagine.id_pagine,pagine.name,navigation.name')->from('pagine inner join navigation')->on('pagine.id_navigation=navigation.id_navigation')->where(array('-name'=>1))->limit(1)->send();
// 		echo $this->m['PagineModel']->getQuery();
// 		echo '<pre>';
// 		print_r($table);
// 		echo '</pre>';
// 		
// 		$table = $this->m['PagineModel']->selectId(87);
// 		echo $this->m['PagineModel']->getQuery();
// 		echo '<pre>';
// 		print_r($table);
// 		echo '</pre>';
// 		
// // 		$table = $this->m['PagineModel']->aWhere(array('name'=>'prima'))->limit(null)->send();
// // 		echo $this->m['PagineModel']->getQuery();
// // 		echo '<pre>';
// // 		print_r($table);
// // 		echo '</pre>';
// 
// 		echo $this->m['PagineModel']->where()->using('id_navigation')->groupBy('navigation.name')->rowNumber()."<br />";
// 		echo $this->m['PagineModel']->getQuery()."<br />";
		
		$table = $this->m['PagineModel']->select('pagine.name,navigation.name')->from('pagine')->inner('navigation')->using('id_navigation')->left('sections')->on('bello')->where()->limit(1)->send();
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}
	
	public function testget()
	{
		$ciao = $this->request->get('ciao','bello','sanitizeAll');
		echo $ciao;
	}
	
	public function status()
	{
		$this->setArgKeys(array('page:forceNat'=>1,'value:sanitizeAll'=>'undef'));
		$this->shift();
		
		echo $this->viewStatus."<br />";
		
		$this->viewArgs['page'] = 'ciao';
		$this->buildStatus();
		echo $this->viewStatus;
		
	}
	
	public function tolist()
	{
		$list = $this->m['PagineModel']->clear()->select('pagine.id_pagine,pagine.name,navigation.name')->from('pagine inner join navigation')->on('pagine.id_navigation=navigation.id_navigation')->toList('id_pagine')->send();
		
		echo $this->m['PagineModel']->getQuery();
		
// 		$list = $this->m['PagineModel']->getList($table,'id_pagine');
		
		echo '<pre>';
		print_r($list);
		echo '</pre>';
		
		$list = $this->m['PagineModel']->clear()->select('pagine.id_pagine,pagine.name,navigation.name')->from('pagine inner join navigation')->using('id_navigation')->toList('pagine.id_pagine','pagine.name')->send();
		
		echo $this->m['PagineModel']->getQuery();
		
// 		$list = $this->m['PagineModel']->getList($table,'pagine.id_pagine','pagine.name');
		
		echo '<pre>';
		print_r($list);
		echo '</pre>';
	}

	public function newupdate()
	{
		$this->m['PagineModel']->values = array(
			'name'  	=>	'nuovo',
			'titolo'	=>	'titolo',
			'html'		=>	'html',
		);
		$this->m['PagineModel']->update(null,'name="123"');
		echo $this->m['PagineModel']->getQuery();
	}

	public function newdel()
	{
		$this->m['PagineModel']->del(null,'name="fghjgj"');
		echo $this->m['PagineModel']->getQuery();
	}
	
	public function aggr()
	{
		$this->clean();
		
// 		echo $this->m['PagineModel']->db->getMax('pagine','id_pagine',null)."<br />";
// 		echo $this->m['PagineModel']->getQuery()."<br />";
		
// 		echo $this->m['PagineModel']->clear()->where(array('id_pagine'=>"<72"))->getMax('id_pagine')."<br />";
// 		echo $this->m['PagineModel']->getQuery();
// 		echo $this->m['PagineModel']->clear()->where(array('id_pagine'=>"<72"))->getMin('id_pagine')."<br />";
// 		echo $this->m['PagineModel']->where(array('id_pagine'=>"<72"))->getAvg('id_pagine')."<br />";
// 		echo $this->m['PagineModel']->where(array('id_pagine'=>"<72"))->getSum('id_pagine')."<br />";
		
		echo $this->m['PagineModel']->where(array(
			"gt"	=>	array("id_pagine"=>96)
		))->getMax('id_pagine');
		print_r($this->m['PagineModel']->db->queries);
	}
	
	public function has()
	{
		$res = $this->m['PagineModel']->clear()->groupBy("pagine.name")->has('pagine.name','12');
		echo $this->m['PagineModel']->getQuery();
		var_dump($res);
	}
	
	public function freequery()
	{
		$table = $this->m['PagineModel']->query('select name from pagine where id_paginre>78;');
		echo $this->m['PagineModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo $this->m['PagineModel']->getError()."<br />";
		echo $this->m['PagineModel']->getErrno()."<br />";
	}

	public function query3()
	{
		$this->m['PagineModel']->db->select('pagine','name','','','','',array('pagine.id_navigation = navigation.id_navigation'),array(null,'id_navigation'),array('l:navigation','sections'));
		echo $this->m['PagineModel']->db->query;
	}

	public function testnojoin()
	{
		$this->m['PagineModel']->select('name')->from('pagine')->on('-')->send();
		echo $this->m['PagineModel']->getQuery();
	}

	public function query4()
	{
		$this->m['PagineModel']->from('pagine')->left('navigation')->right('sections')->on('pagine.id_navigation = navigation.id_navigation')->using('id_section')->send();
// 		print_r($this->m['PagineModel']->on);
		echo $this->m['PagineModel']->getQuery();
	}

	public function testselect()
	{
		$array = array(
			"primo"		=>	1,
			"secondo" 	=>	'2',
		);
		
		echo Html_Form::select('test',"secondo",$array,null,null,'yes');
	}

	public function subfolder()
	{
		
		Params::$viewSubfolder = "Sub";
		$this->load("test");
	}

	public function testupdate()
	{
		$this->m['PagineModel']->values = array(
			'name'  	=>	"",
			'titolo'	=>	'titolo',
			'html'		=>	'html',
		);
		$this->m['PagineModel']->update(96);
		print_r($this->m['PagineModel']->db->queries);
	}

	public function testinsert()
	{
		$this->m['PagineModel']->values = array(
			'name'  	=>	"aa",
			'titolo'	=>	'aa',
			'html'		=>	'aa',
			'id_navigation'		=>	'115',
		);
		
		$this->m['PagineModel']->db->beginTransaction();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->insert();
		$this->m['PagineModel']->db->commit();
		
		echo $this->m['PagineModel']->notice;
		
		print_r($this->m['PagineModel']->db->queries);
// 		$mysqli = Db_Mysqli::getInstance();
// 		print_r($mysqli->queries);
	}
	
	public function query5()
	{
		$this->m['PagineModel']->from('pagine')->inner('navigation')->on('pagine.id_navigation = navigation.id_navigation')->where(array("navigation.id_navigation"=>1))->send();
// 		print_r($this->m['PagineModel']->on);
		echo $this->m['PagineModel']->getQuery();
	}
	
	public function query6()
	{
// 		$this->m['PagineModel']->clear()->where(array('id_pagine'=>"<72"))->send();
// 		$this->m['PagineModel']->clear()->where(array('id_pagine'=>"like '%72%'"))->send();

		$this->m['PagineModel']->clear()->where(array('titolo'=>"lk:ciao"))->send();
		print_r($this->m['PagineModel']->db->queries);
	}
	
	public function query7()
	{
		Params::$nullQueryValue = "tutti";
		
		$where = array(
			'lk'	=>	array(
				"titolo"	=>	"bello"
			),
			'in'	=>	array(
				"id_page"	=>	array(1,2,3,4,5),
			),
			'nin'	=>	array(
				"id_page"	=>	array(1,2,3,4,5),
			),
			'lt'	=>	array(
				"id_page"	=>	"<7"
			),
			'lte'	=>	array(
				"id_page"	=>	7
			),
			'gt'	=>	array(
				"id_page"	=>	7
			),
			'gte'	=>	array(
				"id_page"	=>	7
			),
			'ne'	=>	array(
				"id_page"	=>	"7"
			),
		);
		
// 		$where = array(
// 			"titolo" => "ciao",
// 			
// 			"OR" => array(
// 				'lk'	=>	array(
// 					"id_navigation"	=>	"bello"
// 				),
// 				' lk'	=>	array(
// 					"id_navigation"	=>	"brutto"
// 				),
// // 				'in'	=>	array(
// // 					"tabella.id_page"	=>	array(1,2,3,4,5),
// // 				),
// // 				'nin'	=>	array(
// // 					"n!id_page"	=>	array(1,2,3,4,5),
// // 				),
// // 				'lt'	=>	array(
// // 					"id_page"	=>	7
// // 				),
// // 				'lte'	=>	array(
// // 					"id_page"	=>	7
// // 				),
// // 				'gt'	=>	array(
// // 					"id_page"	=>	7
// // 				),
// // 				'gte'	=>	array(
// // 					"id_page"	=>	7
// // 				),
// // 				'ne'	=>	array(
// // 					"id_page"	=>	"7"
// // 				),
// 			),
// 		);
		
// 		$where = array(
// 			"gte"	=>	array(
// 				"n!datediff('2016-07-06',pages.dal)"	=>	0.5,
// 			),
// 			
// 		);
		
		$this->m['PagineModel']->where($where)->send();
		print_r($this->m['PagineModel']->db->queries);
	}
	
	public function cleanquery()
	{
		Params::$setValuesConditionsFromDbTableStruct = false;
		
		$this->m['PagineModel']->clearConditions("strong");
		$this->m['PagineModel']->clearConditions("database");
		$this->m['PagineModel']->clearConditions("values");
		
		$this->m['PagineModel']->foreignKeys = array();
		
		$aa = "lk:likegg: <%aaa%";
		$aa = sanitizeDb($aa);
		
		$where = array(
			"titolo" => $aa,
		);
		
		$this->m['PagineModel']->clear()->where($where)->send();
		echo $this->m['PagineModel']->getQuery();
		
		$this->m['PagineModel']->values = array(
			"titolo"	=>	$aa,
			"id_navigation"	=>	1		
		);
		$this->m['PagineModel']->update(1);
		$this->m['PagineModel']->insert();
		
		echo $this->m['PagineModel']->notice;
		print_r($this->m['PagineModel']->db->queries);
// 		$aa = sanitizeAll("like lk: %aaa%");
		
// 		echo $aa;
	}
	
	public function q()
	{
		$res = $this->m['PagineModel']->send(false);
		
		print_r($res);
	}
	
	public function q2()
	{
		$sql = "select *,count(*) as numero from articles where category = 'economia' group by category";
// 		
		$res = $this->m['PagineModel']->db->QueryArray($sql);
// 		
		$sql = "select *,count(*) as numero from articles where category = 'economia' group by category";
// 		
		$res = $this->m['PagineModel']->db->QuerySingleRowArray($sql);
		
// 		$db = Db_Mysqli::getInstance();
		
// 		$res = $db->QuerySingleRowArray($sql);
		
		print_r($res);
	}
	
	public function i1()
	{
		$this->m['PagineModel']->clearConditions("strong");
		$this->m['PagineModel']->clearConditions("database");
		$this->m['PagineModel']->clearConditions("values");
		
		$this->m['PagineModel']->setValues(array(
			'name'  	=>	'"',
		));
		
		$this->m['PagineModel']->setValue("id_navigation",148);
// 		$this->m['PagineModel']->setValue("name","aa'");
		
// 		$this->m['PagineModel']->insert();
		
		$this->m['PagineModel']->update(3);
		
		echo $this->m['PagineModel']->notice;
		
		print_r($this->m['PagineModel']->db->queries);
	}
	
	public function insertrow()
	{
		$db = Db_Mysqli::getInstance();
		
		$values = array(
			"name"			=>	"ultimo",
			"id_navigation"	=>	"159",
		);
		
		$res = $db->InsertRow("pagine", $values);
		
		var_dump($res);
		
		$values = array(
			"name"			=>	"ultimo secondo",
			"id_navigation"	=>	"159",
		);
		
		$res = $db->UpdateRows("pagine", $values, "id_pagine = 1");
// 		
		var_dump($res);
	}
	
	public function i2()
	{
		$this->clean();
		
		$this->model("MacchinariModel");
		
		$this->m['MacchinariModel']->addValuesCondition("both","checkNotEmpty","titolo");
		
		$this->m['MacchinariModel']->setValues(array(
			'titolo'  		=>	'aa',
			'descrizione'  	=>	'',
		));
		
		$this->m['MacchinariModel']->insert();
		
		echo $this->m['MacchinariModel']->notice;
	}
	
	public function save()
	{
		$this->m['PagineModel']->clear()->select("a")->where(array("a"=>3))->save()->aWhere(array("b"=>2))->send();
		
		echo $this->m['PagineModel']->getQuery();
		
		$this->m['PagineModel']->save()->clear()->select("c")->send();
		
		echo $this->m['PagineModel']->getQuery();
		
		$this->m['PagineModel']->restore(true);
		
		$this->m['PagineModel']->send();
		
		echo $this->m['PagineModel']->getQuery();
		
		$this->m['PagineModel']->restore();
		
		$this->m['PagineModel']->send();
		
		echo $this->m['PagineModel']->getQuery();
	}
	
	public function autosanitize()
	{
		$res = $this->m['PagineModel']->clear()->select("id_pagine,name")->where(array(
			"IN"	=>	array("id_pagine" => array(
				"88","87",
			))
		))->send(false);
		
		print_r($res);
		
		print_r($this->m['PagineModel']->db->queries);
		
// 		echo $this->m['PagineModel']->getError();
	}
	
	public function testretations()
	{
		$this->model("CategoryModel");
		
		$this->m["CategoryModel"]->right(array("pages"))->send();
// 		
// 		echo $this->m["CategoryModel"]->getQuery();
		
		$this->m['PagineModel']->right(array("categories"))->send();
		
		$this->model("RegusersModel");
		
		$this->m['RegusersModel']->right(array("groups"))->send();
	}
	
	public function testlaravel()
	{
		$this->clean();
		
		$users = $this->m['PagineModel']->clear()->send(false);
		
// 		print_r($users);
		foreach ($users as $u)
		{
			echo $u["name"]."<br />";
		}
	}
	
	public function testqueryall()
	{
		$res = $this->m['PagineModel']->db->query(array("select * from pagine where id_pagine = ?",array(97)),false);
		
		$res = $this->m['PagineModel']->db->query("select * from pagine where id_pagine = 97",false);
		
		print_r($this->m['PagineModel']->db->queries);
		
		print_r($res);
	}
	
	public function testswhere()
	{
		$res = $this->m['PagineModel']->select("name")->sWhere(array(
			"name = ? or name = ?", array("aa", 11)
		))->send(false);
		
		print_r($res);
	}
}
