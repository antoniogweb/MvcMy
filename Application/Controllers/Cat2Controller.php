<?php

//test controller to verify that it is possible to use a scaffold with a model having an arbitrary name

class Cat2Controller extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->modelName = 'CategoryModel';
		$this->model('CategoryModel');
		$this->session('admin');
		$this->m['CategoryModel']->setFields('name,tick,visibile,categoria,css,meta_ita','sanitizeAll');

		$this->setArgKeys(array('page:forceNat'=>1,'name:sanitizeAll'=>'undef','token:sanitizeAll'=>'token'));
		
		$this->m['CategoryModel']->supplUpdateValues = array('immagine'=>time());
	}

	public function index() {
		echo '<h2>It works!!</h2>';
	}

	public function main() {
		$this->shift();

		$this->s['admin']->check();
// 		if (!$this->s['admin']->checkCsrf($this->viewArgs['token'])) $this->redirect('panel/main',2,'wrong token');

		$this->loadScaffold('main',array('popup'=>true));
		$this->scaffold->setWhereQueryClause(array('name'=>$this->viewArgs['name']));
		$this->scaffold->loadMain('navigation:id_navigation,navigation:name','navigation:id_navigation','edit,moveup,movedown,del');
		$this->scaffold->update('del,moveup,movedown');
		$this->scaffold->setHead('ID DELLA CATEGORIA,NOME DELLA CATEGORIA');
		$data['scaffold'] = $this->scaffold->render();
		
		$this->set($data);
		$this->load('view');

	}

	public function form($queryType) {
		$this->shift(1);
		
		$this->s['admin']->check();
// 		if (!$this->s['admin']->checkCsrf($this->viewArgs['token'])) $this->redirect('panel/main',2,'wrong token');

		$this->m['CategoryModel']->updateTable('insert,update');
		echo $this->m['CategoryModel']->getQuery();

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"cat2/form/$queryType");
// 		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model');
// 		$this->scaffold->setFormEntries('model',array('css'=>'password','categoria'=>'password'));
// 		$array = array('Di Antonio'=>'Antonio','Di Giulia'=>'Giulia','Di Fabiano'=>'Fabiano');
		$this->scaffold->form->setEntry('tick','Checkbox','1');
		$this->scaffold->form->setEntry('visibile','Radio',array('visibile'=>'1','invisibile'=>'2'));
		$data['scaffold'] = $this->scaffold->render();

		$this->set($data);
		$this->load('view');
	}

}