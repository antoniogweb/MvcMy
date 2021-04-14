<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class PasswordController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$this->load('header');
		$this->load('footer','last');

		$this->helper('Menu','users','panel/main');
		$this->helper('Array');

		$this->session('admin');
		$this->model('UsersModel');

		$this->m['UsersModel']->setFields('password:sha1','none');

		$this->m['UsersModel']->strongConditions['update'] = array('checkEqual'=>'password,confirmation');
		$this->m['UsersModel']->strongConditions['insert'] = array('checkEqual'=>'password,confirmation');

		$this->m['UsersModel']->identifierName = 'id_user';

// 		$this->setArgKeys(array('page:forceInt'=>1,'field:sanitizeAll'=>'all','value:sanitizeAll'=>1));
	}

	public function form()
	{
		$this->shift(0);

		$this->s['admin']->check();

		$data['notice'] = null;
		
		$id = (int)$this->s['admin']->status['id_user'];
		if (isset($_POST['updateAction'])) {
			$pass = $this->s['admin']->getPassword();
			if (sha1($_POST['old']) === $pass)
			{
				$this->m['UsersModel']->updateTable('update',$id);
				$data['notice'] = $this->m['UsersModel']->notice;
				if ($this->m['UsersModel']->queryResult)
				{
					$this->s['admin']->logout();
					$this->redirect('users/login',3,'logout');
				}
			}
			else
			{
				$data['notice'] = "<div class='alert'>Vecchia password sbagliata</div>\n";
			}
		}
		$data['menù'] = $this->h['Menu']->render('panel');

		$values = $this->m['UsersModel']->selectId($id);
// 		$values['old'] = '';
// 		$values['confirmation'] = '';
		
		$action = array('updateAction'=>'save');
		$form = new Form_Form('password/form/update/',$action);
		$form->setEntry('old','Password');
		$form->entry['old']->labelString = 'old password:';
		$form->setEntry('password','Password');
		$form->setEntry('confirmation','Password');
		$data['form'] = $form->render($values,'old,password,confirmation');

		$this->set($data);
		$this->load('form');
	}

	public function formscaff()
	{
		$this->shift(0);

		$this->s['admin']->check();

		$data['notice'] = null;
		
		$id = (int)$this->s['admin']->status['id_user'];
		if (isset($_POST['updateAction'])) {
			$pass = $this->s['admin']->getPassword();
			if (sha1($_POST['old']) == $pass)
			{
				$this->m['UsersModel']->updateTable('update',$id);
				$data['notice'] = $this->m['UsersModel']->notice;
				if ($this->m['UsersModel']->queryResult)
				{
					$this->s['admin']->logout();
					$this->redirect('users/login',3,'logout');
				}
			}
			else
			{
				$data['notice'] = "<div class='alert'>Vecchia password sbagliata</div>\n";
			}
		}
		$data['menù'] = $this->h['Menu']->render('panel');

		$values = $this->m['UsersModel']->selectId($id);
		$values['old'] = '';
		$values['confirmation'] = '';
		
		$action = array('updateAction'=>'save');
		$form = new Form_Form('password/form/update/',$action);
		$form->setEntry('old','Password');
		$form->entry['old']->labelString = 'old password:';
		$form->setEntry('password','Password');
		$form->setEntry('confirmation','Password');
		$data['form'] = $form->render($values,'old,password,confirmation');

		$this->set($data);
		$this->load('form');
	}
}