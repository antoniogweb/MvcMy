<?php

if (!defined('EG')) die('Direct access not allowed!');

class MacchinariModel extends Model_Tree {

	public function __construct() {
		$this->_tables='macchinari';
		$this->_idFields='id_m';

		$this->_idOrder = 'id_order';
		
		parent::__construct();
	}
}