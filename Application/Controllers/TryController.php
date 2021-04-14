<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class TryController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->model();
		$this->m['TryModel']->setFields('name,titolo,html,abstract','sanitizeAll');
		$this->m['TryModel']->strongConditions['update'] = array('checkNotEmpty'=>'name,titolo');
		$this->m['TryModel']->databaseConditions['update'] = array('checkUniqueCompl'=>'name');
// 		$this->m['TryModel']->validateConditions['insert'] = 'checkEmpty:id_navigation';

		$this->setArgKeys(array('page:forceInt'=>1,'field'=>'all','value'=>1));
	}

	public function main() {
		$this->shift();

// 		$this->m['TryModel']->popupBuild();

		$this->loadScaffold('main');
		$this->scaffold->loadMain('pagine:id_pagine,pagine:name,pagine:titolo,pagine:id_navigation','pagine:id_pagine');
		$this->scaffold->update();
		$data['scaffold'] = $this->scaffold->render();
		$this->set($data);
		$this->load('main');
	}

	public function form($queryType) {
		$this->shift(1);

		if (isset($_POST['updateAction']))
		{
			$id = (int)$_POST['id_pagine'];
			$this->m['TryModel']->update($id);
		}
		
		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"try/form/$queryType");
// 		$this->scaffold->update();
		$this->scaffold->getFormValues('sanitizeHtml');
// 		print_r($this->scaffold->values);
		$this->scaffold->setFormEntries('model',array('html'=>'Textarea','abstract'=>'Textarea'));
// 		$this->scaffold->form->entry['abstract']->className = 'ciao';
// 		print_r($this->scaffold->form->entry['abstract']);
// 		$array = array('riflessioni'=>1,'complications'=>2,'quisquiglie'=>3);
// 		$this->scaffold->form->setEntry('id_navigation','Select',$array);
// 		$this->scaffold->form->setEntry('autore','select','Antonio,Giulia,Fabiano');
		$data['form'] = $this->scaffold->render();

		$this->set($data);
		$this->load('form');
	}

	public function test() {

		$array = $this->m['TryModel']->getFieldArray('pagine:id_pagine','pagine:titolo');
		echo $this->m['TryModel']->getQuery();
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}

}