<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class GroupsController extends Controller {

	protected $fields; //fields for the update or insert query
	protected $values; //value for the update or insert query

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$this->load('header');
		$this->load('footer','last');

		$this->helper('MenuHelper','groups','panel/main');
		$this->helper('ArrayHelper');

		$this->session('admin');
		$this->model();

		$this->m['GroupsModel']->setFields('name','sanitizeAll');

		$this->m['GroupsModel']->strongConditions['update'] = array('checkNotEmpty'=>'name');
		$this->m['GroupsModel']->strongConditions['insert'] = array('checkNotEmpty'=>'name');

		$this->m['GroupsModel']->databaseConditions['insert'] = array('checkUnique'=>'name');
		$this->m['GroupsModel']->databaseConditions['update'] = array('checkUniqueCompl'=>'name');

// 		$this->m['GroupsModel']->identifierName = 'id_user';

		$this->setArgKeys(array('page:forceInt'=>1,'field:sanitizeAll'=>'username','value:sanitizeAll'=>'undefined'));
	}

	public function main() {
		$this->shift();

		$this->s['admin']->check('users,root');

		$this->loadScaffold('main');
		$this->scaffold->loadMain('admingroups:id_group,admingroups:name','admingroups:id_group','edit,del');
		$this->scaffold->update('del');
		$data['scaffold'] = $this->scaffold->render();
		$this->set($data);
		$this->load('main');

	}

	public function form($queryType)
	{
		$this->shift(1);

		$this->s['admin']->check('users,root');

		$this->loadScaffold('form');
		$this->scaffold->loadForm($queryType,"groups/form/$queryType");
		$this->scaffold->update('insert,update');
		$this->scaffold->getFormValues('sanitizeHtml');
		$this->scaffold->setFormEntries('model');
		$data['scaffold'] = $this->scaffold->render();

		$this->set($data);
		$this->load('main');
	}
	
}