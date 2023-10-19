<?php

// MvcMy is a flexible and easy-to-use PHP MVC framework to use together with MvcMyLibrary
// Copyright (C) 2009 - 2023  Antonio Gallo (info@laboratoriolibero.com)
// See LICENSE.txt.
// 
// This file is part of MvcMy
// 
// MvcMy is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// MvcMy is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with MvcMy.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

class PasswordController extends BaseController {

	function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);

		$this->helper('Menu','users','panel');
		$this->helper('Array');

		$this->session('admin');
		$this->model('UtentiModel');

		$this->m['UtentiModel']->setFields('password:sha256','none');

		$this->m['UtentiModel']->strongConditions['update'] = array('checkEqual'=>'password,confirmation');

		$this->m['UtentiModel']->identifierName = 'id_user';
		
		$this->setArgKeys(array('token:sanitizeAll'=>'token'));
		$this->shift();
		
		$this->s['admin']->check();
	}

	public function form($queryType = 'update', $id = 0)
	{
		$this->shift(0);
		
		$data['notice'] = null;
		
		$id = (int)$this->s['admin']->status['id_user'];
		if (isset($_POST['updateAction'])) {
			$pass = $this->s['admin']->getPassword();
			if (sha256($_POST['old']) === $pass)
			{
				$this->m['UtentiModel']->updateTable('update',$id);
				$data['notice'] = $this->m['UtentiModel']->notice;
				if ($this->m['UtentiModel']->queryResult)
				{
// 					$this->s['admin']->logout();
// 					$this->redirect('users/login',3,'logout');
				}
			}
			else
			{
				$data['notice'] = "<div class='alert alert-danger'>Vecchia password sbagliata</div>\n";
			}
		}
		$data['menù'] = $this->h['Menu']->render('panel');

		$values = $this->m['UtentiModel']->selectId($id);
		$values['old'] = '';
		$values['confirmation'] = '';
		
		$action = array('updateAction'=>'salva');
		$form = new Form_Form('password/form/'.$this->viewArgs['token'],$action);
		$form->className = "form-horizontal main_form";
		$form->setEntry('old','Password');
		$form->entry['old']->labelString = 'Vecchia password:';
		$form->setEntry('password','Password');
		$form->setEntry('confirmation','Password');
		$form->entry['password']->labelString = 'Nuova password:';
		$form->entry['confirmation']->labelString = 'Conferma la password:';
		
		$form->entry['old']->className = 'form-control';
		$form->entry['password']->className = 'form-control';
		$form->entry['confirmation']->className = 'form-control';
		
		$data['form'] = $form->render($values,'old,password,confirmation');

		$this->append($data);
		$this->load('form');
	}

}
