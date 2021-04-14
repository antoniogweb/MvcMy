<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class NewsController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');
		$this->session('admin');
		$this->model();
		$this->m['NewsModel']->setFields('title,giornale,content','sanitizeAll');
		$this->m['NewsModel']->strongConditions['update'] = array('checkAlphanum'=>'title');
		$this->m['NewsModel']->strongConditions['insert'] = array('checkAlphanum'=>'title');
// 		
		$this->m['NewsModel']->databaseConditions['insert'] = array('checkUnique'=>'title');
		$this->m['NewsModel']->databaseConditions['update'] = array('checkUniqueCompl'=>'title');
		
		$this->setArgKeys(array('page:forceNat'=>1));
	}
	
	public function main() {

		$this->s['admin']->check('root');
		$this->shift();
		$this->loadScaffold('main');
		$this->scaffold->loadMain('news:id,news:title','news:id');
		$this->scaffold->update('del');
		$data['xxx'] = $this->scaffold->render();
		$this->set($data);
		$this->load('main');

	}

	public function form($queryType) {
		
		$this->s['admin']->check('root');

		$this->shift(1);

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"news/form/$queryType");
		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model');
		$this->scaffold->form->setEntry('content','Textarea');
		$array = array('notizie dal corriere'=>'corriere','da repubblica'=>'repubblica');
		$this->scaffold->form->setEntry('giornale','Select',$array);
// 		$array = 'right,left,center,top,bottom';
// 		$this->scaffold->form->setEntry('title','Select',$array);
// 		$this->scaffold->form->entry['xml']->className = 'contentArea';
		$this->scaffold->form->entry['content']->labelString = 'scrivi qui il content:';
// 		$guideArray = array('allowed titles'=>'right');
// 		$values = array_merge($this->scaffold->values,$guideArray);
		$data['xxx'] = $this->scaffold->render();

		$this->set($data);
		$this->load('main');
	}

}