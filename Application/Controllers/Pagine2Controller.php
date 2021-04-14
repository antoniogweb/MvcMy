<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class Pagine2Controller extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->helper('Array');
		$this->helper('Menu','pagine2','panel');
		$this->model();
		$this->session('admin');
		$this->m['Pagine2Model']->setFields('name,id_navigation,titolo,html','sanitizeAll');
// 		$this->m['Pagine2Model']->validateConditions['insert'] = 'checkLength|10:titolo;';
// 		$this->m['Pagine2Model']->validateConditions['update'] = 'checkLength|10:titolo;';
		
// 		$this->m['Pagine2Model']->strongConditions['update'] = array(
// 			'+checkAlphaNum'	=>	'name',
// 			'checkNotEmpty'		=>	'id_navigation'
// 		);
// 
// 		$this->m['Pagine2Model']->strongConditions['insert'] = array(
// 			'checkAlphaNum'	=>	'name',
// 			'checkNotEmpty'	=>	'id_navigation'
// 		);
// 
// 		$this->m['Pagine2Model']->softConditions['update'] = array(
// 			'checkIsStrings|pagina1,1,2'	=>	'titolo',
// 			'checkIsNotStrings|undef'		=>	'name',
// 			'checkIsNotStrings|my'			=>	'name'
// 		);
// 
// 		$this->m['Pagine2Model']->softConditions['insert'] = array(
// 			'checkIsStrings|pagina1,1,2'	=>	'titolo',
// 			'checkIsNotStrings|undef'		=>	'name',
// 			'checkIsNotStrings|my'			=>	'name'
// 		);
		
		$this->setArgKeys(array('page:forceNat'=>1));
	}

	public function index() {
		echo '<h2>It works!!</h2>';
	}

	public function main() {
		
		$this->shift();
		
		$this->s['admin']->check();

// 		$params = array('popup'=>true);
		
// 		echo $this->viewArgs['value'];
		$this->loadScaffold('main');
// 		$this->scaffold->setWhereQueryClause(array('-id_navigation'=>$this->viewArgs['value']));
// 		print_r($this->scaffold->model->getWhereQueryClause());
		$this->scaffold->loadMain('pagine:id_pagine,pagine:name,navigation:name,pagine:html','pagine:id_pagine','moveup,movedown,edit,del');
		$this->scaffold->setHead('ID,NOME DELLA PAGINA,NOME DELLA CATEGORIA,HTML');
		$this->scaffold->update('del,moveup,movedown');
		$this->scaffold->fields = 'pagine.id_pagine,pagine.name,navigation.name,pagine.html';
		$this->scaffold->pageList->nextString = ">>";
		$this->scaffold->pageList->previousString = "<<";
		$this->scaffold->render();
// 		echo $this->scaffold->model->getQuery();
		
		$data['menù'] = $this->scaffold->html['menu'];
		$data['main'] = $this->scaffold->html['main'];
		$data['pageList'] = $this->scaffold->html['pageList'];
// 		$data['popup'] = $this->scaffold->html['popup'];
		$data['notice'] = $this->scaffold->model->notice;
		
// 		$data['popup'] = $this->m['Pagine2Model']->getFieldArray('navigation:id_navigation','navigation:name');
		
		$this->set($data);
		$this->load('main');

	}

	public function form($queryType) {
		$this->shift(1);

		$this->s['admin']->check();

		$this->m['Pagine2Model']->setForm("pagine2/form/$queryType",array($queryType.'Action'=>'save'));
		$this->m['Pagine2Model']->updateTable('insert,update');
		$value = $this->m['Pagine2Model']->getFormValues($queryType,'sanitizeHtml');
		$data['form'] = $this->m['Pagine2Model']->form->render($value);
		
		$data['notice'] = $this->m['Pagine2Model']->notice;
		$data['menù'] = $this->h['Menu']->render('back');
		
		$this->set($data);
		$this->load('form');
	}
	
}