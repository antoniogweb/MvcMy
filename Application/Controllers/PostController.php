<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class PostController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->model();
		$this->session('admin');
		$this->m['PostModel']->setFields('titolo,interop,autore,testo,intero,interom,interot,interob,xxx,fff','sanitizeAll');
		
		$this->m['PostModel']->strongConditions['update'] = array('checkAlphaNum'=>'titolo');
		
		$this->m['PostModel']->strongConditions['insert'] = array('checkNotEmpty'=>'all|devi riempire tutti i campi...');

		$this->m['PostModel']->softConditions['insert'] = array('checkAlphaNum'=>'testo','checkNumeric'=>'fff','checkDigit'=>'intero,interop');
		$this->m['PostModel']->softConditions['update'] = array('checkNumeric'=>'fff','checkDigit'=>'intero,interop');

		$this->m['PostModel']->databaseConditions['insert'] = array(
			'checkUnique'	=>	'titolo',
			'+checkUnique'	=>	'intero|intero gi&agrave presente'
		);
		$this->m['PostModel']->databaseConditions['update'] = array(
			'checkUniqueCompl'	=>	'titolo|titolo gi&agrave presente',
			'+checkUniqueCompl'	=>	'intero|intero gi&agrave presente'
		);

		$argKeys = array(
			'pager:forceNat'=>1,
			'autore:sanitizeAll'=>'undefi',
			'-id:sanitizeAll'=>'undefi',
			'-id_arg:sanitizeAll'=>'undefi',
			'n!dayofmonth(post.time):sanitizeAll'=>'undefi',
			'n!dayname(post.time):sanitizeAll'=>'undefi',
			'n!monthname(post.time):sanitizeAll'=>'undefi'
		);

		$this->setArgKeys($argKeys);
		Params::$nullQueryValue = 'undefi';

// 		Params::$nullQueryValue = false;
		
		$data2['ciao'] = 'ciao';
		$this->set($data2);
	}

	public function index() {
		echo '<h2>It works!!</h2>';
		$data['bello'] = 'bello';
		$this->append($data);
		$this->load('index');
	}

	public function main() {
		$this->shift();

		$this->s['admin']->check();
		$params = array('pageVariable' => 'pager','pageList' => true,'popup'=>true,'popupType'=>'inclusive');
		$this->loadScaffold('main',$params);
		$whereClauseArray = array(
			'autore'	=>	$this->viewArgs['autore'],
			'-id'		=>	$this->viewArgs['-id'],
			'-id_arg'	=>	$this->viewArgs['-id_arg'],
			'n!dayofmonth(post.time)'	=>	$this->viewArgs['n!dayofmonth(post.time)'],
			'n!dayname(post.time)'	=>	$this->viewArgs['n!dayname(post.time)'],
			'n!monthname(post.time)'	=>	$this->viewArgs['n!monthname(post.time)']
		);
		$this->scaffold->setWhereQueryClause($whereClauseArray);
		$this->scaffold->loadMain('post:id,post:titolo,post:autore,aggregate:month','post:id','');
// 		$this->scaffold->addItem('simpleLink','post/modify2/update/;post:id;',null,'Edit');
// 		$this->scaffold->addItem('simpleLink','post/associateold/;post:id;',null,'Associate');
// 		$this->scaffold->addItem('simpleLink','post/associate2/;post:id;',null,'Associate2');
		$this->scaffold->addItem('moveupForm','post/main',';post:id;');
		$this->scaffold->addItem('movedownForm','post/main',';post:id;');
		$this->scaffold->addItem('editForm','post/form/update',';post:id;');
		$this->scaffold->addItem('delForm','post/main',';post:id;');
		$this->scaffold->update('del,moveup,movedown');
		$this->scaffold->fields = 'post.id,post.titolo,post.autore,month(post.time) as month';
		$this->scaffold->setHead('ID,TITOLO,AUTORE,MESE');
		$this->scaffold->popupMenu->allString = 'tutti';
// 		$this->scaffold->itemList->submitImageType = 'yes';
		
		$data['scaffold'] = $this->scaffold->render();
// 		echo $this->scaffold->model->getQuery();
		$this->set($data);
		$this->load('view');

	}

	public function form($queryType)
	{
		$this->shift(1);

		$this->s['admin']->check();

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"post/form/$queryType");
		$this->scaffold->update('insert,update');
// 		echo $this->scaffold->model->getQuery();
		if ($this->scaffold->model->queryResult)
		{
			$logFile = Files_Log::getInstance('users');
			$logFile->writeString("IP:".getIp()."\tUSER:".$this->s['admin']->status['user']."\tAction:".$this->scaffold->model->submitName);
		}
		$this->scaffold->getFormValues('sanitizeHtml',null,array('testo'=>'scrivi qui il tuo testo'));
		$this->scaffold->setFormEntries('model',array('testo'=>'Textarea','autore'=>'Select'));
// 		$array = array('Di Antonio'=>'Antonio','Di Giulia'=>'Giulia','Di Fabiano'=>'Fabiano');
		$array = 'optgroupOpen:conosciuti,Antonio,Giulia,Fabiano,optgroupOpen:sconosciuti,cavolacci,a';
// 		$array = array('conosciuti'=>'optgroupOpen','Antonio'=>'Antonio','Giulia'=>'Giulia','Fabiano'=>'Fabiano','sconosciuti'=>'optgroupOpen','cavolacci'=>'cavolacci','aeee'=>'a');
		$this->scaffold->form->setEntry('autore','Select',$array);
		$this->scaffold->form->id = 'test';
		
		$data['form'] = $this->scaffold->render();

		$this->set($data);
		$this->load('modify');
	}

	public function associateold($id)
	{
		$this->shift(1);

// 		$this->s['admin']->check();

		$this->m['PostModel']->updateTable('associate,dissociate',$id);

		$data['notice'] = $this->m['PostModel']->notice;

		$this->helper('Menu','post','panel/main');
		$data['menu'] = $this->h['Menu']->render('back');

		$data['action'] = $this->baseUrl.'/post/associate/'.$id.$this->viewStatus;

		$data['argomenti'] = $this->m['PostModel']->getFieldArray('argomenti:id_arg','argomenti:title');
		$this->set($data);
		$this->load('form_associate_2');
	}

	public function associate2($id)
	{
		$this->shift(1);
// 		$this->s['admin']->check();

		$this->m['PostModel']->updateTable('associate,dissociate');

		$data['notice'] = $this->m['PostModel']->notice;

		$this->helper('Menu','post','panel/main');
		$data['menu'] = $this->h['Menu']->render('back');

		$data['action'] = $this->baseUrl.'/post/associate2/'.$id.$this->viewStatus;

		$data['argomenti'] = $this->m['PostModel']->getFieldArray('argomenti:id_arg','argomenti:title');
		$data['id'] = $id;
		$this->set($data);
		$this->load('form_associate_2');
	}

	public function modify2($queryType,$id) {
		$this->shift(2);

// 		$this->s['admin']->check();

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"post/modify2/$queryType/$id");
		$this->scaffold->update($id);
		$this->scaffold->getFormValues('sanitizeHtml',$id);
		$this->scaffold->setFormEntries('model',array('testo'=>'Textarea','autore'=>'Select'));
		$this->scaffold->form->setEntry('autore','Select','Antonio,Giulia,Fabiano');
		$data['form'] = $this->scaffold->render();

		$this->set($data);
		$this->load('modify');
	}

	public function update($id = null) {
		$this->shift(1);

// 		$this->s['admin']->check();

		$this->m['PostModel']->updateTable($id);
		$data['notice'] = $this->m['PostModel']->notice;

		$this->getFormValues('update','sanitizeHtml',$id);
		$data['values'] = $this->values;
		$data['action'] = url::getRoot('post/update/'.$id.$this->viewStatus);

		$data['hidden'] = "<input type='hidden' name='identifier' value='" . $id . "'>\n";
		$data['submit'] = "updateAction";

		$data['topMenu'] = $this->h['MenuHelper']->render('panel,back');

		$this->set($data);
		$this->load('form');
	}

	public function popup() {
		$this->shift();

		$data['popup'] = $this->h['PopupHelper']->render();

		$this->set($data);
		$this->load('popup');
	}

	public function test() {

		$array = $this->m['PostModel']->getFieldArray('argomenti:id_arg','argomenti:id_arg');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($array);
		echo '</pre>';

	}

	public function query() {
		$where = array('id' => '> 6');
		$this->m['PostModel']->setWhereQueryClause($where);
		$this->m['PostModel']->orderBy = 'id';
		$this->m['PostModel']->limit = 3;
// 		$this->m['PostModel']->appendWhereQueryClause(array('titolo'=>'ciao'));
		$table = $this->m['PostModel']->getAll();
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}

	public function test33()
	{
		$this->m['PostModel']->setSubmitNames('associate','updatePlipplio');
		echo $this->m['PostModel']->getSubmitName('associate');
	}

	function check()
	{
		echo sanitizeCustom('qwwe qwe','|');
		
	}

	function gett()
	{
		$this->m['PostModel']->getAll('qweqe');
	}
	
	function type()
	{
		$db = Factory_Db::getInstance(DATABASE_TYPE);
		$types = $db->getTypes('post', 'id,titolo,testo,autore,time,xxx,fff,intero,interop,interom,interob,interot');
		echo '<pre>';
		print_r($types);
		echo '</pre>';
	}

	function desc()
	{
		$query = 'describe post;';
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			echo $row['Type'];
		}
// 		echo '<pre>';
// 		var_dump($result);
// 		echo '</pre>';
	}
	
	function query2()
	{
// 		var_dump($this->m['PostModel']->rawDel('post','id=80'));
// 		echo $this->m['PostModel']->getQuery();
// 		$data = $this->m['PostModel']->db->select('pagine inner join navigation','navigation.name,pagine.name,count(*) as conto,sum(navigation.id_navigation) as somma',null,null,null,null,'pagine.id_navigation=navigation.id_navigation');
		$data = $this->m['PostModel']->db->select('pagine,navigation','navigation.name,pagine.name,count(*) as conto,sum(navigation.id_navigation) as somma','pagine.id_navigation=navigation.id_navigation',null,null,null);
		echo $this->m['PostModel']->getQuery();
// 		foreach ($data as $row)
// 		{
// 			echo $row['aggregate']['conto']."<br />";
// 		}
// 		echo $data[0]['aggregate']['conto'];
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		
		echo 'ciao';
	}

	function fields()
	{
		$this->m['PostModel']->orderBy = 'autore';
// 		$this->m['PostModel']->groupBy = 'autore';
		$data = $this->m['PostModel']->getFields('id,titolo','Items');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		
		echo 'ciao';
	}

	public function neighbours()
	{
		$this->m['PostModel']->setWhereQueryClause(array('id'=>'42','id_arg'=>1));
		
		$table = $this->m['PostModel']->getNeighbours('id','titolo,post.id');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo 'ciao';
	}

	function recursive()
	{
		$this->m['PostModel']->logicalOperators = array('AND','AND','OR');
		
		$queryClause = array(
			'titolo'	=>	'7777',
			'n!dayofmonth(post.time)' => '11',
			'level1'	=>	array(
								'-id'		=>	'100',
								'level2'	=>	array(
													'-id'	=>	'100',
													'-id_arg'	=>	'1',
													'n!dayofmonth(post.time)' => '11'
												),
							),
			'level2'	=>	array(
								'-id_arg'	=>	'1'
							)
		);
		
		$this->m['PostModel']->setWhereQueryClause($queryClause);
// 		$this->m['PostModel']->orderBy = 'autore';
// 		$this->m['PostModel']->groupBy = 'autore';
		$data = $this->m['PostModel']->getFields('post.id,titolo','Items');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		
		echo 'ciao';
	}
	
	public function testdate()
	{
		$queryClause = array('n!dayofmonth(post.time)'=>'19');
		$this->m['PostModel']->setWhereQueryClause($queryClause);
		$table = $this->m['PostModel']->getFields('post.titolo');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}
	
	public function queryerror()
	{
		$this->m['PostModel']->getFields('poste.titolo');
		echo $this->m['PostModel']->db->getErrno().'<br />';
		echo $this->m['PostModel']->db->getError().'<br />';
	}

	public function dynamicquery()
	{
		$table = $this->m['PostModel']->select('title')->limit()->where(array('title'=>'stoffa'))->orderBy()->send('Items');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo $this->m['PostModel']->rowNumber()."<br />";
		echo $this->m['PostModel']->getQuery();
// 		echo $this->m['PostModel']->on;
	}
	
	public function newdel()
	{
		$this->m['PostModel']->del(null,'titolo="555r"');
		echo $this->m['PostModel']->getQuery();
	}
	
	public function tolist()
	{
		$list = $this->m['PostModel']->clear()->select('title,titolo')->where(array('title'=>'stoffa'))->orderBy()->toList('post.titolo','argomenti.title')->send('Items');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($list);
		echo '</pre>';
	}
	
	public function aggr()
	{
		echo $this->m['PostModel']->db->getMax('post','id',null)."<br />";
		echo $this->m['PostModel']->getQuery()."<br />";
		
		echo $this->m['PostModel']->clear()->where(array('id'=>">100"))->getMax('id')."<br />";
		echo $this->m['PostModel']->getQuery();
		echo $this->m['PostModel']->clear()->where(array('id'=>">100"))->getMin('id')."<br />";
		echo $this->m['PostModel']->where(array('id'=>">100"))->getAvg('id')."<br />";
		echo $this->m['PostModel']->where(array('id'=>">100"))->getSum('id')."<br />";
	}
	
	public function has()
	{
		$res = $this->m['PostModel']->clear()->where(array('title'=>'pannolenci'))->has('post.titolo','213');
		echo $this->m['PostModel']->getQuery();
		var_dump($res);
	}
	
	public function freequery()
	{
		$table = $this->m['PostModel']->query('select titolo,id from post where idt>78;');
		echo $this->m['PostModel']->getQuery();
		echo '<pre>';
		print_r($table);
		echo '</pre>';
		
		echo $this->m['PostModel']->getError()."<br />";
		echo $this->m['PostModel']->getErrno()."<br />";
	}
	
}