<?php

if (!defined('EG')) die('Direct access not allowed!');

class ReggroupsModel extends Model_Tree {
	
	public function __construct() {
		$this->_tables='reggroups';
		$this->_idFields='id_group';
		
		$this->_lang = 'It';
		
		parent::__construct();
	}
	
}
