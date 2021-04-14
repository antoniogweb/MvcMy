<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class UsersController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$this->load('header');
		$this->load('footer','last');

		$this->helper('Menu','users','panel/main');
		$this->helper('Array');

		$this->session('admin');
		$this->model();

// 		var_dump( ADMIN_ALLOW_MULTIPLE_ACCESSES );
		
		$this->m['UsersModel']->setFields('username:sanitizeAll,password:sha1','none');

		$this->m['UsersModel']->strongConditions['update'] = array('checkAlphaNum'=>'username','checkEqual'=>'password,confirmation');
		$this->m['UsersModel']->strongConditions['insert'] = array('checkAlphaNum'=>'username','checkEqual'=>'password,confirmation');

		$this->m['UsersModel']->databaseConditions['insert'] = array('checkUnique'=>'username');
		$this->m['UsersModel']->databaseConditions['update'] = array('checkUniqueCompl'=>'username');

// 		$this->m['UsersModel']->identifierName = 'id_user';

		$this->setArgKeys(array('page:forceNat'=>1,'id_group:forceInt'=>'0'));
		Params::$nullQueryValue = '0';
	}

// 	public function login() {
// 		$data['action'] = Url::getRoot('users/login');
// 
// 		$this->s['admin']->checkStatus();
// 		if ($this->s['admin']->status['status']=='logged') { //check if already logged
// 			$this->s['admin']->redirect('logged');
// 		} else {
// 			if (isset($_POST['username']) and isset($_POST['password'])) {
// 				$this->s['admin']->login(sanitizeAll($_POST['username']),$_POST['password']);
// 			}
// 		}
// 		$this->set($data);
// 		$this->load('login');
// 	}

	public function login()
	{
		$data['action'] = Url::getRoot('users/login');
		$data['notice'] = null;
		
		$this->s['admin']->checkStatus();
		if ($this->s['admin']->status['status']=='logged') { //check if already logged
			$this->s['admin']->redirect('logged');
		}
		if (isset($_POST['username']) and isset($_POST['password']))
		{
			$choice = $this->s['admin']->login(sanitizeAll($_POST['username']),$_POST['password']);

			switch($choice) {
				case 'logged':
					$this->redirect('panel/main',3,'You are already logged...');
					break;
				case 'accepted':
// 					$db = Factory_Db::getInstance(DATABASE_TYPE);
// 					echo $db->query;
					$this->redirect('panel/main',3,'Hi '.$this->s['admin']->status['user'].'...');
					break;
				case 'login-error':
					$data['notice'] = '<div class="alert">Wrong username or password</div>';
					break;
				case 'wait':
					$data['notice'] = '<div class="alert">You have to wait 5 seconds before you can try to login another time</div>';
					break;
			}
		}
		$this->set($data);
		$this->load('login');
	}
	
	public function logout() {
		$res = $this->s['admin']->logout();
		if ($res == 'not-logged') {
			$data['notice'] = "<div class='alert'>You can't logout because you are not logged..</div>\n";

		} else if ($res == 'was-logged') {
			$data['notice'] = "<div class='executed'>Logout executed successfully!</div>\n";

		} else if ($res == 'error') {

		}

		$data['login'] = Url::getRoot('users/login');
		$this->set($data);
		$this->load('logout');
	}

	public function forceout($id)
	{
		$this->s['admin']->check('users,root');
		$data['menù'] = $this->h['Menu']->render('back');
		$data['notice'] = null;
		$id = (int)$id;
		if (strcmp($this->s['admin']->status['id_user'],$id) !== 0)
			{
			if ($this->s['admin']->forceOut($id))
			{
				$data['notice'] = "<div class='executed'>User has been forced out..</div>\n";
			}
			else
			{
				$data['notice'] = "<div class='alert'>Error..</div>\n";
			}
		}
		
		$this->set($data);
		$this->load('forceout');
	}

	public function retype() {
		echo 'retype your password please';
	}

	public function main() { //view all the users
		$this->shift();

		$this->s['admin']->check('users,root');
// 		var_dump($this->s['admin']->status['id_user']);
		$this->loadScaffold('main',array('popup'=>true));
		$this->scaffold->setWhereQueryClause(array('id_group'=>$this->viewArgs['id_group']));
		$this->scaffold->loadMain('adminusers:id_user,adminusers:username','adminusers:id_user','del,edit,link');
		$this->scaffold->addItem('simpleLink','users/forceout/;adminusers:id_user;',null,'ForceOut');
		$this->scaffold->update('del');
		$data['scaffold'] = $this->scaffold->render();
		echo $this->scaffold->model->getQuery();
		$this->set($data);
		$this->load('main');
	}

// 	public function form2($queryType = 'insert')
// 	{
// 		$this->shift(1);
// 
// 		$this->s['admin']->check('users,root');
// 
// 		if (isset($_POST['updateAction'])) {
// 			if ($_POST['password'] == '' and $_POST['confirmation'] == '')
// 			{
// 				$_POST = $this->h['ArrayHelper']->subsetComplementary($_POST,'password,confirmation');
// 				$this->m['UsersModel']->delFields('password,confirmation');
// 			}
// 		}
// 		$this->m['UsersModel']->updateTable('insert,update');
// 		$this->m['UsersModel']->restoreFields();
// 
// // 		echo $this->m['UsersModel']->getQuery();
// 
// 		if ($queryType == 'update') {
// 			//take the values from the table at id=$_POST['id_user']
// 			$values = $this->m['UsersModel']->selectId((int)$_POST['id_user']);
// 			$values['confirmation'] = '';
// 			//set the submit name=updateAction, value=save
// 			$action = array('updateAction'=>'save');
// 		} else if ($queryType == 'insert') {
// 			if ($this->m['UsersModel']->result) {
// 				$values = $this->h['ArrayHelper']->subset(array(),'username,password,confirmation','sanitizeHtml');
// 			} else {
// 				$values = $this->h['ArrayHelper']->subset($_POST,'username,password,confirmation','sanitizeHtml');
// 			}
// 			$action = array('insertAction'=>'save');
// 		}
// 
// 		$data['notice'] = $this->m['UsersModel']->notice;
// 		$data['menù'] = $this->h['MenuHelper']->render('panel,back');
// 
// 		$form = new Form_Form('users/form/'.$queryType,$action);
// 		$form->setEntry('username','InputText');
// 		$form->setEntry('password','Password');
// 		$form->setEntry('confirmation','Password');
// 		$form->setEntry('id_user','Hidden');
// 		$data['form'] = $form->render($values,'username,password,confirmation,id_user');
// 
// 		$this->set($data);
// 		$this->load('form');
// 	}

	public function form($queryType = 'insert')
	{
		$this->shift(1);

		$this->s['admin']->check('users,root');

		$this->m['UsersModel']->updateTable('insert,update');

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"users/form/$queryType");
		//test: add an entry not in the database
		$this->m['UsersModel']->fields .= ',confirmation,bo';
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model',array('password'=>'Password'));
		$this->scaffold->form->setEntry('confirmation','Password');
// 		$this->scaffold->form->setEntry('bo','InputText');
		$this->scaffold->form->setEntry('html','Html');
		$this->scaffold->values['html'] = 'hello!!';
// 		$array = array('confirmation'=>'');
// 		$values = array_merge($this->scaffold->values,$array);
		$data['scaffold'] = $this->scaffold->render(null,'username,password,confirmation,id_user,bo,html');
		
		$this->set($data);
		$this->load('main');
	}

	public function associate()
	{
		$this->shift(0);

		$this->s['admin']->check('users,root');
		$this->m['UsersModel']->printAssError = 'yes';
		$this->m['UsersModel']->updateTable('associate,dissociate');

		$data['notice'] = $this->m['UsersModel']->notice;

		$data['menu'] = $this->h['Menu']->render('back');

		$data['action'] = $this->baseUrl.'/users/associate'.$this->viewStatus;

		$data['groups'] = $this->m['UsersModel']->getFieldArray('admingroups:id_group','admingroups:name');

		//get the name of the user whose id is $_POST['id_user']
		$users = $this->m['UsersModel']->db->select('adminusers','username','id_user='.(int)$_POST['id_user']);
		$data['user'] = $users[0]['adminusers']['username'];
		
		//get the groups inside which the user is inserted
		$this->m['UsersModel']->setWhereQueryClause(array('id_user'=>(int)$_POST['id_user']));
		$this->m['UsersModel']->orderBy = 'admingroups.id_group desc';
		$data['groupsUser'] = $this->m['UsersModel']->getAll('Boxes');
// 		echo $this->m['UsersModel']->getQuery();
		
		$this->set($data);
		$this->load('associate');
	}

}