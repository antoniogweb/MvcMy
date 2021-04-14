<?php

if (!defined('EG')) die('Direct access not allowed!');

class RegusersgroupsModel extends Model_Tree {
	
	public function __construct() {
		$this->_tables='regusers_groups';
		$this->_idFields='id_ug';
		
		$this->orderBy = 'id_order desc';
		
		$this->_lang = 'It';
		$this->_idOrder = 'id_order';
		
		parent::__construct();
	}
	
	
	
}
