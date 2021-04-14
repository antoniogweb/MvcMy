<?php

if (!defined('EG')) die('Direct access not allowed!');

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class PostnewModel extends Model_Map
{

	public $formStruct = array(
	
		'entries' 	=> 	array(
			'titolo'	=> 	array(),
			'autore'	=>	array(
				'type'		=>	'Select',
				'options'	=>	'foreign::navigation::name::name!=\'eee\'::--::id_navigation desc',
// 				'options'	=>	'Antonio,Giulia,Fabiano',
				'labelString'=>	'chi sei tu che scrivi?',
				'entryClass'=>	'wqeqwe'
			),
			'testo'		=>	array(
				'type'		=>	'Textarea',
			),
			'id'		=>	array(
				'type'		=>	'Hidden'	
			)
		),
		
// 		'submit'	=>	array('updateAction' => 'save'),
// 		
// 		'action'	=>	'postnew/form',
// 		
// 		'method'	=>	'POST'
	
	);
	
	public function __construct()
	{
		$this->_tables='post,argomenti,arg_post';
		$this->_idFields='id,id_arg';
		$this->_where=array('id'=>'post','autore'=>'post','titolo'=>'post','id_arg'=>'argomenti');
		$this->_popupItemNames=array('autore'=>'autore','id'=>'titolo','id_arg'=>'title');
		$this->orderBy = 'post.id_order desc';
		$this->_idOrder = 'id_order';
		$this->_lang = 'It';
		parent::__construct();
	}

}