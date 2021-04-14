<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class ArticlesController extends Controller {

	public function __construct($model, $controller, $queryString, $application) {
		parent::__construct($model, $controller, $queryString, $application);
		
		$this->load('header');
		$this->load('footer','last');

		$this->session('admin');
		$this->session('registered');
		$this->model();
		$this->m['ArticlesModel']->setFields('title,author,category,abstract,content','sanitizeAll');

		$this->m['ArticlesModel']->strongConditions['update'] = array(
			'checkMatch|/^[a-z]*$/'	=>	'title'
		);
		
		$this->setArgKeys(array('page:forceNat'=>1,'n!author:sanitizeAll'=>'undef','category:sanitizeAll'=>'undef','title:sanitizeAll'=>'undef'));

// 		Params::$nullQueryValue = false;
// 		Params::$rewriteStatusVariables = false;
		
		$this->controller('BoxController');
	}

	function index() {
// 		echo $this->m['ArticlesModel']->orderBy;
		$this->setArgKeys(array('page:forceNat'=>1));
		$this->shift();
		$this->s['registered']->checkStatus();
// 		echo $this->s['registered']->uid;
		//the current page
		$page = $this->viewArgs['page'];
		//load the PageDivisionHelper helper
		$this->helper('Pages','articles/index');
		//number of record of the post table
		$this->m['ArticlesModel']->setWhereQueryClause(array('id'=>'>0'));
		$recordNumber = $this->m['ArticlesModel']->rowNumber();
		//get the limit of the select query carried out by the getAll method
		$this->m['ArticlesModel']->limit = $this->h['Pages']->getLimit($page,$recordNumber,3);
		$data['pageList'] = $this->h['Pages']->render($page-1,3);
		
		$data['table'] = $this->m['ArticlesModel']->getAll();
		$data['title'] = 'mywebsite.org';

		print_r($this->m['ArticlesModel']->getWhereQueryClause());

		$this->set($data);

		$this->clean();

		$this->load('header_public');
		
		$this->c['BoxController']->right();
		
		$this->load('viewall');
		$this->load('footer_public');
	}

	function view($id = 1) {
// 		echo $this->m['ArticlesModel']->orderBy;
		$this->s['registered']->check('base,root',0);
		$this->m['ArticlesModel']->setWhereQueryClause(array('id'=>(int)$id));

		//get the neighbours
		$data['neighbours'] = $this->m['ArticlesModel']->getNeighbours('id','title,id');
	
		$table = $this->m['ArticlesModel']->getAll();
		echo $this->m['ArticlesModel']->getQuery();
		
		$data['row'] = $table[0];
		$data['title'] = $data['row']['articles']['title'];
		
		$this->set($data);

		$this->clean();
		$this->load('header_public');
		$this->c['BoxController']->right();
		$this->load('view');
		$this->load('footer_public');
	}

	public function main()
	{

		$this->s['admin']->check();
// 		echo $this->s['admin']->getPassword();
// 		print_r($this->s['admin']->status);
// 		echo $this->s['admin']->uid;
		$this->shift();
		
// 		print_r($this->_queryString);
// 		echo "<br />";
// 		print_r($this->viewArgs);
		
// 		echo getUserAgent();
		$params = array('popup'=>true,'popupType'=>'inclusive');
		$this->loadScaffold('main',$params);
		$this->scaffold->setWhereQueryClause(array('n!author'=>$this->viewArgs['n!author'],'category'=>$this->viewArgs['category'],'title'=>$this->viewArgs['title']));
		$this->scaffold->loadMain('articles:title,articles:author,articles:category','articles:id');
		$this->scaffold->update('del');
		$this->scaffold->itemList->setFilters(array(array('title','Titolo:'),array('n!author','Autore:'),array('category','Categoria:')));
		$this->scaffold->itemList->aggregateFilters();
		
		$this->scaffold->model->where(array(
			"title"		=>	$this->viewArgs["title"],
			"n!author"	=>	$this->viewArgs["n!author"],
			"category"	=>	$this->viewArgs["category"],
		));
		$this->scaffold->pageList->showNext = false;
		
		$this->scaffold->itemList->setBulkActions(array(
			"input_navigation_ordine"	=>	array("ordinaAction","Conferma colonna ORDINAMENTO"),
			"checkbox_navigation_visibile"	=>	array("mostraAction","Conferma colonna VISIBILE"),
			"checkbox_navigation_id_navigation"	=>	array("eliminaAction","Elimina elementi selezionati (colonna SEL)","confirm"),
		));
		
		$data['scaffold'] = $this->scaffold->render();
// 		echo  $this->scaffold->model->getQuery();
		
		$this->scaffold->itemList->showFilters = false;
		echo $this->scaffold->itemList->createFilters();
// 		echo $this->request->cookie('uid','qweqwe','sanitizeAll');
		$this->set($data);
		$this->load('main');

	}

	public function form($queryType) {
		$this->s['admin']->check('root',2);

		$this->shift(1);

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"test/articles/form/$queryType");
		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model',array('category'=>'Select','abstract'=>'Textarea','content'=>'Textarea'));
		$array = array('politica'=>'politica','economia'=>'economia','cultura'=>'cultura');
		$this->scaffold->form->setEntry('category','Select',$array);
		$this->scaffold->form->entry['content']->className = 'contentArea';
		$this->scaffold->form->entry['abstract']->idName = 'abstract';
		$data['scaffold'] = $this->scaffold->render();

		$this->set($data);
		$this->load('main');
	}

	function test() {
		$row = $this->m['ArticlesModel']->select('title')->where(array('category'=>'!="cultura"'))->rowNumber();
		echo $this->m['ArticlesModel']->getQuery();
		echo '<pre>';
		print_r($row);
		echo '</pre>';
	}
	
	public function fff()
	{
		echo "fff";
	}

}