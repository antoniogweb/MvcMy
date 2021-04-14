<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class PersonalController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

// 		$this->load('header');
// 		$this->load('footer','last');
// 
// 		$this->helper('MenuHelper','users','panel/main');
// 		$this->helper('ArrayHelper');

		$this->session('registered');
		$this->controller('BoxController');
// 		$this->model();

// 		$this->m['UsersModel']->setFields('username:sanitizeAll,password:sha1','none');
// 
// 		$this->m['UsersModel']->validateConditions['update'] = 'checkAlphaNum:username;checkEqual:password,confirmation';
// 		$this->m['UsersModel']->validateConditions['insert'] = 'checkAlphaNum:username;checkEqual:password,confirmation';
// 
// 		$this->m['UsersModel']->databaseConditions['insert'] = 'checkUnique:username';
// 		$this->m['UsersModel']->databaseConditions['update'] = 'checkUniqueCompl:username';
// 
// 		$this->m['UsersModel']->identifierName = 'id_user';
// 
// 		$this->setArgKeys(array('page:forceInt'=>1,'field:sanitizeAll'=>'all','value:sanitizeAll'=>1));
	}

	public function login()
	{
		$data['title'] = 'login page';
		$data['action'] = $this->baseUrl.'/personal/login';
		$data['notice'] = null;
		$this->s['registered']->checkStatus();
		if ($this->s['registered']->status['status'] === 'logged') { //check if already logged
			$this->s['registered']->redirect('logged');
		}
		if (isset($_POST['username']) and isset($_POST['password']))
		{
			$choice = $this->s['registered']->login(sanitizeAll($_POST['username']),$_POST['password']);

			switch($choice) {
				case 'logged':
					$this->redirect('articles/index',3,'You are already logged...');
					break;
				case 'accepted':
					$this->redirect('articles/index',3,'Hi '.$this->s['registered']->status['user'].'...');
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

		$this->load('header_public');
		$this->c['BoxController']->right();
		$this->load('login');
		$this->load('footer_public');
	}

	public function logout()
	{
		$data['title'] = 'logout page';
		$data['notice'] = null;
		$res = $this->s['registered']->logout();
		if ($res == 'not-logged') {
			$data['notice'] = "<div class='alert'>You can't logout because you are not logged..</div>\n";

		} else if ($res == 'was-logged') {
			$data['notice'] = "<div class='executed'>Logout executed successfully!</div>\n";

		} else if ($res == 'error') {

		}
		$this->set($data);

		$this->load('header_public');
		$this->c['BoxController']->right();
		$this->load('logout');
		$this->load('footer_public');
	}

}