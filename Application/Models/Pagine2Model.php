<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class Pagine2Model extends Model_Tree {

	public function __construct() {
		$this->_tables='pagine';
		$this->_idFields='id_pagine';
		$this->_where=array('id_pagine'=>'pagine','-id_navigation'=>'navigation','-name'=>'pagine','name'=>'navigation','n!dayofmonth(pagine.time)'=>'pagine');
// 		$this->_popupItemNames=array('-id_navigation'=>'name','-name'=>'name');
		$this->orderBy = 'pagine.id_ordinamento desc';
		$this->_onDelete = 'nocheck';
		$this->_lang = 'It';
		$this->_idOrder = 'id_ordinamento';
		
		$this->from = 'pagine inner join navigation';
		$this->using = 'id_navigation';
// 		$this->on = "navigation.id_navigation = pagine.id_navigation";
		
		parent::__construct();
	}

	public $formStruct = array(
		'entries' 	=> 	array(
			'name'	=> 	array(),
			'id_navigation'	=>	array(
				'type'		=>	'Select',
				'options'	=>	'foreign::navigation::name,id_navigation::--::--::id_navigation desc',
			),
			'titolo'		=>	array(),
			'html'			=>	array(
				'type'		=>	'Textarea'
			),
			'id_pagine'	=>	array(
				'type'		=>	'Hidden'	
			)
		),	
	);
	
}