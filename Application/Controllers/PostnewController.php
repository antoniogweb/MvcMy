<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PostnewController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

		$this->helper('Menu','postnew','panel');
		$this->h['Menu']->links['add']['text'] = 'Aggiungi';
		$this->h['Menu']->links['new']['text'] = 'New';
		$this->h['Menu']->links['new']['url'] = 'form/insert';
		$this->h['Menu']->links['new']['class'] = 'mainMenuItem';
		
		$this->helper('Array');

		//load the model named PostnewModel
		$this->model('PostnewModel');
		//set the fields of the table that have to be managed by the insert and update queries
		$this->m['PostnewModel']->setFields('titolo,autore,testo','sanitizeAll');
		//set the validate conditions for the update and the insert queries
		$this->m['PostnewModel']->strongConditions['update'] = array('checkNotEmpty'=>'titolo,autore,testo');
		$this->m['PostnewModel']->strongConditions['insert'] = array('checkNotEmpty'=>'all|nessun valore deve essere nullo');
		//set the autoarguments
		
		$this->m['PostnewModel']->databaseConditions['insert'] = array(
			'checkUnique'	=>	'titolo'
		);
		$this->m['PostnewModel']->databaseConditions['update'] = array(
			'checkUniqueCompl'	=>	'titolo'
		);
		
		$this->setArgKeys(array('page:forceNat'=>1,'autore:sanitizeAll'=>'undef','id:sanitizeAll'=>'undef','id_arg:sanitizeAll'=>'undef'));
		//set the key of the value of the $_POST array that contain the primary key of the table
		$this->m['PostnewModel']->identifierName= 'id';
	}

	public function main()
	{
		$this->shift();

		/*
			WHERE CLAUSE
		*/
		//set the where clause
		$whereClauseArray = array(
			'autore'	=>	$this->viewArgs['autore'],
			'id'		=>	$this->viewArgs['id'],
			'id_arg'	=>	$this->viewArgs['id_arg']
		);
		$this->m['PostnewModel']->setWhereQueryClause($whereClauseArray);
		
		/*
			UPDATE TABLE
		*/

		//call the updateTable method
		$this->m['PostnewModel']->updateTable('del,moveup,movedown');
		//prepare the $notice variable
		$data['notice'] = $this->m['PostnewModel']->notice;

		/*
			POPUP MENÙ
		*/

		//create the popup array
		$this->m['PostnewModel']->popupBuild();
		$popup = $this->m['PostnewModel']->popupArray;
// 		echo '<pre>';
// 		print_r($popup);
// 		echo '</pre>';
		
		//load the PopupHelper helper
		$this->helper('Popup','postnew/main',$popup,'exclusive','page');
		//create the HTML of the popup
		$data['popup'] = $this->h['Popup']->render();

		/*
			PAGE DIVISION
		*/

		//the current page
		$page = $this->viewArgs['page'];
		//load the PageDivisionHelper helper
		$this->helper('Pages','postnew/main');
		//number of record of the post table
		$recordNumber = $this->m['PostnewModel']->rowNumber();
		//get the limit of the select query carried out by the getAll method
		$this->m['PostnewModel']->limit = $this->h['Pages']->getLimit($page,$recordNumber,10);
		$data['pageList'] = $this->h['Pages']->render($page-2,5);

		/*
			TOP MENÙ
		*/

		$data['menù'] = $this->h['Menu']->render('panel,add,new');

		$data['table'] = $this->m['PostnewModel']->getAll('Items');
		echo $this->m['PostnewModel']->getQuery();
		
		$data['viewStatus'] = $this->viewStatus;
		$this->set($data);
		$this->load('main');

	}

	public function form($queryType = 'insert')
	{
		$this->shift(1);

		/*
			UPDATE TABLE
		*/
		echo $this->request->post('updateAction','bello','sanitizeAll');
		
		if (isset($_POST['updateAction']))
		{
			$this->m['PostnewModel']->updateTable('update');
// 			$id = (int)$_POST['id'];
// 			if ($this->m['PostnewModel']->checkConditions('update',$id)) $this->m['PostnewModel']->update($id);
			echo $this->m['PostnewModel']->getQuery();
		}
		
		if (isset($_POST['insertAction']))
		{
			if ($this->m['PostnewModel']->checkConditions('insert')) $this->m['PostnewModel']->insert();
		}
// 		$this->m['PostnewModel']->updateTable('insert,update');

		/*
			RETRIEVE DATA FOR THE FORM ENTRIES
		*/

// 		$this->m['PostnewModel']->setForm();
		
		if ($queryType == 'update') {
			$this->m['PostnewModel']->setForm(null,array('updateAction'=>'save'));
// 			$this->m['PostnewModel']->form->submit = array('updateAction'=>'save');
			$action = array('updateAction'=>'save');
		} else if ($queryType == 'insert') {
			$this->m['PostnewModel']->setForm(null,array('insertAction'=>'save'));
// 			$this->m['PostnewModel']->form->submit = array('insertAction'=>'save');
			$action = array('insertAction'=>'save');
		}

		$values = $this->m['PostnewModel']->getFormValues($queryType,'sanitizeHtml');
		
		$data['notice'] = $this->m['PostnewModel']->notice;
		$data['menù'] = $this->h['Menu']->render('back');
		/*
			FORM
		*/

// 		$entries = array(
// 		
// 			'titolo'	=>	array(
// 				'type'		=>	'InputText',
// 				'class'		=>	'my_class',
// 				'label'		=>	'titolo mio:',
// 				'id'		=>	'my_id',
// 				'divClass'	=>	'form_entry',
// 				'labelClass'=>	'entryLabel',
// 				'default'	=>	'ciao io sono il default value',
// 			),
// 			
// 			'autore'	=>	array(
// 				'type'		=>	'Radio',
// 				'options'	=>	'Antonio,Giulia,Fabiano'
// 			),
// 			
// // 			'testo'	=> array(),
// 			'testo'		=>	array(
// 				'type'		=>	'Textarea',
// 				'wrap'		=>	array(null,'<div>prima della text area</div>','<div>dopo la text area</div>'),
// // 				'divClass'	=>	'sdfsdf'
// 			),
// 			
// 			'id'		=>array('type' => 'Hidden')
// 		
// 		);
		
// 		$this->m['PostnewModel']->form->submit = $action;
// 		$this->m['PostnewModel']->form->action = 'postnew/form/'.$queryType;
// 		$this->m['PostnewModel']->form->setEntry('id','Hidden');
// 		$data['form'] = $this->m['PostnewModel']->form->render($values);
// 		$data['form'] = $this->m['PostnewModel']->form->render($values,'titolo,autore,testo,id');


// 		$form = new Form_Form('postnew/form/'.$queryType,$action);
// 		$form->setEntry('titolo','InputText');
// 		$form->setEntry('autore','InputText');
// 		$form->setEntry('testo','Textarea');
// 		$form->setEntry('id','Hidden');
		$this->m['PostnewModel']->form->action = 'postnew/form/'.$queryType;
		$data['form'] = $this->m['PostnewModel']->form->render($values);
// 		$form = new Form_Form('postnew/form/'.$queryType,$action);
// 		$form->setEntries($entries);
// // 		$data['form'] = $form->render();
// 		$data['form'] = $form->render($values);
		$this->set($data);
		$this->load('form');
	}

}