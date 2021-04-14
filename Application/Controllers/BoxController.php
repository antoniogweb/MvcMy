<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class BoxController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$this->session('admin');
		$this->model();
		$this->m['BoxModel']->setFields('title,xml','sanitizeAll');
		$this->m['BoxModel']->strongConditions['insert'] = array('checkNotEmpty'=>'title','checkAlphanum'=>'title');
		$this->m['BoxModel']->strongConditions['update'] = array('checkNotEmpty'=>'title','checkAlphanum'=>'title');
		
		$this->m['BoxModel']->databaseConditions['insert'] = array('checkUnique'=>'title');
		
		$this->setArgKeys(array('page:forceInt'=>1,'field'=>'id','value'=>'undef'));
	}
	
	public function right()
	{
// 		$this->clean();
		
		$this->m['BoxModel']->setWhereQueryClause(array('title'=>'right'));
		$data = $this->m['BoxModel']->getAll('boxes');

		$xml = htmlspecialchars_decode($data[0]['boxes']['xml'],ENT_QUOTES);

		$box = new BoxParser($xml);
		$data['htmlBox'] = $box->render();
		
// 		$box = new BoxParser('/home/tonicucoz/apache/file.xml','file');
// 		echo $box->render();
		
		$this->append($data);
		$this->load('rightbox');
	}

	public function main() {

		$this->s['admin']->check();
		$this->shift();
		$this->loadScaffold('main');
		$this->scaffold->loadMain('boxes:id,boxes:title,boxes:xml','boxes:id','edit,del,moveup,movedown');
		$this->scaffold->update('del');
		$data['scaffold'] = $this->scaffold->render();
		$this->set($data);
		$this->load('header');
		$this->load('main');
		$this->load('footer');

	}

	public function form($queryType) {
		
		$this->s['admin']->check();

		$this->shift(1);

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"box/form/$queryType");
		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model',array('xml'=>'Textarea'));
		$this->scaffold->form->setEntry('allowed titles','Select','right,left,top,bottom,center');
// 		$array = 'right,left,center,top,bottom';
// 		$this->scaffold->form->setEntry('title','Select',$array);
		$this->scaffold->form->entry['xml']->className = 'contentArea';
		$this->scaffold->form->entry['xml']->labelString = 'scrivi qui i moduli';
		$guideArray = array('allowed titles'=>'right');
		$values = array_merge($this->scaffold->values,$guideArray);
		$data['scaffold'] = $this->scaffold->render($values,'allowed titles,title,xml,id');

		$this->set($data);
		$this->load('header');
		$this->load('main');
		$this->load('footer');
	}

}