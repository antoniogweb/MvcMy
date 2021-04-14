<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class MessagesController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->load('header');
		$this->load('footer','last');

// 		$this->session('admin');
// 		$this->session('registered');
		$this->model();
		$this->m['MessagesModel']->setFields('nome,messaggio','sanitizeAll');
		$this->m['MessagesModel']->strongConditions['insert'] = array('checkNotEmpty'=>'nome,messaggio');
// 		$this->setArgKeys(array('page:forceInt'=>1,'field'=>'all','value'=>1));

		$this->controller('BoxController');
	}

	public function insert($id = 1)
	{
		session_start();
		$id = (int)$id;
		$data['notice'] = null;
		$this->m['MessagesModel']->supplInsertValues = array('id_pagine' => $id);
		if (isset($_POST['insertAction']))
		{
			if ($_SESSION['captchaString'] == $_POST['captcha'])
			{
				$this->m['MessagesModel']->updateTable('insert',$id);
				$data['notice'] = $this->m['MessagesModel']->notice;
			}
			else
			{
				$this->m['MessagesModel']->result = false;
				$data['notice'] = "<div class='alert'>Wrong captcha...</div>\n";
			}
		}
		
		$this->helper('Array');
		$data['values'] = $values = $this->h['Array']->subset(array(),'nome,messaggio','sanitizeHtml');
		if ($this->m['MessagesModel']->result === false)
		{
			$data['values'] = $values = $this->h['Array']->subset($_POST,'nome,messaggio','sanitizeHtml');
		}
		
		$data['title'] = 'Insert page';
		$data['action'] = $this->baseUrl.'/messages/insert/'.$id;
		$this->set($data);
		
		$this->clean();
		$this->load('header_public');
		$this->c['BoxController']->right();
		$this->load('view');
		$this->load('footer_public');
	}

}