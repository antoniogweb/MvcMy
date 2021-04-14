<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class SupplController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->model();
		$this->m['SupplModel']->setFields('name,categoria,css,meta_ita','sanitizeAll');
// 		$this->m['SupplModel']->validateConditions['update'] = 'checkNotEmpty:name';
// 		$this->m['SupplModel']->validateConditions['insert'] = 'checkNotEmpty:name';
// 
// 		$this->m['SupplModel']->databaseConditions['update'] = 'checkUniqueCompl:name';
// 		$this->m['SupplModel']->databaseConditions['insert'] = 'checkUnique:name';

		$this->m['SupplModel']->supplInsertValues = array('ordine' =>2,'immagine'=>'kjasueue');

		$this->setArgKeys(array('page:forceNat'=>1));
	}

	public function index() {
		echo '<h2>It works!!</h2>';
	}

	public function main() {
		$this->shift();

		$this->m['SupplModel']->updateTable('del,moveup,movedown');


// 		print_r($_POST);
		

		$this->helper('List','id_navigation');
		$this->h['List']->submitImageType = 'yes';

		$folder = $this->baseUrlSrc . '/Public/Img/';
		$this->h['List']->submitImages = array(
			'EDIT'=>$folder.'document_properties.png',
		);
		
		$this->h['List']->addItem("simpleText",";navigation.id_navigation;");
		$this->h['List']->addItem("simpleText",";navigation:name;");
		$this->h['List']->addItem("simpleText",";navigation:visibile;");
		$this->h['List']->addItem("simpleText",";aggregate:month;");
		$this->h['List']->addItem("simpleText",";aggregate:day;");
		$this->h['List']->addItem("simpleText",";my_date|navigation:time;");
		$this->h['List']->addItem('moveupForm','suppl/main',';navigation:id_navigation;');
		$this->h['List']->addItem('movedownForm','suppl/main',';navigation:id_navigation;');
		$this->h['List']->addItem('editForm','suppl/form/update',';navigation:id_navigation;');
		$this->h['List']->addItem('delForm','suppl/main',';navigation:id_navigation;');
		$this->h['List']->addItem('Form','suppl/form/update',';navigation:id_navigation;','EDIT','updateAction','edit the record ;navigation:id_navigation;');

		$this->h['List']->setHead('ID,NOME,VISIBILE,MONTH,DAY,DATE');
		$data = $this->m['SupplModel']->getFields('id_navigation,name,visibile,monthname(time) as month,dayname(time) as day,time');
// 		echo $this->m['SupplModel']->getQuery();
		$data['scaffold'] = $this->h['List']->render($data);
// 		$this->loadScaffold('main');
// 		$this->scaffold->loadMain('navigation:id_navigation,navigation:name','navigation:id_navigation');
// 		$this->scaffold->update('del');
// 		$data['scaffold'] = $this->scaffold->render();
		$this->set($data);
		$this->load('view');

	}

	public function form($queryType) {
		$this->shift(1);

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"suppl/form/$queryType");
		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model');
// 		$array = array('Di Antonio'=>'Antonio','Di Giulia'=>'Giulia','Di Fabiano'=>'Fabiano');
// 		$this->scaffold->form->setEntry('autore','select',$array);
		$data['form'] = $this->scaffold->render();

		$this->set($data);
		$this->load('form');
	}

// 	public function modify2($queryType,$id) {
// 		$this->shift(2);
// 
// 		$this->loadScaffold('form');
// 		$this->scaffold->loadForm($queryType,"post/modify2/$queryType/$id");
// 		$this->scaffold->update($id);
// 		$this->scaffold->getFormValues('sanitizeHtml',$id);
// 		$this->scaffold->setFormEntries('model',array('testo'=>'textarea','autore'=>'select'));
// 		$this->scaffold->form->setEntry('autore','select','Antonio,Giulia,Fabiano');
// 		$data['form'] = $this->scaffold->render();
// 
// 		$this->set($data);
// 		$this->load('modify');
// 	}
// 
// 	public function update($id = null) {
// 		$this->shift(1);
// 
// 		$this->m['PostModel']->updateTable($id);
// 		$data['notice'] = $this->m['PostModel']->notice;
// 
// 		$this->getFormValues('update','sanitizeHtml',$id);
// 		$data['values'] = $this->values;
// 		$data['action'] = url::getRoot('post/update/'.$id.$this->viewStatus);
// 
// 		$data['hidden'] = "<input type='hidden' name='identifier' value='" . $id . "'>\n";
// 		$data['submit'] = "updateAction";
// 
// 		$data['topMenu'] = $this->h['MenuHelper']->render('panel,back');
// 
// 		$this->set($data);
// 		$this->load('form');
// 	}
// 
// 	public function popup() {
// 		$this->shift();
// 
// 		$data['popup'] = $this->h['PopupHelper']->render();
// 
// 		$this->set($data);
// 		$this->load('popup');
// 	}
// 
// 	public function test() {
// 
// 		$array = $this->m['PostModel']->getFieldArray('argomenti:id_arg','argomenti:id_arg');
// 		echo $this->m['PostModel']->getQuery();
// 		echo '<pre>';
// 		print_r($array);
// 		echo '</pre>';
// 
// 	}
}