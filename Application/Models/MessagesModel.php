<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class MessagesModel extends Model_Tree {

	public function __construct() {
		$this->_tables='commenti';
		$this->_idFields='id';
		$this->_where=array('id'=>'commenti');
		$this->_popupItemNames=array();
		$this->orderBy = 'id desc';
// 		$this->_reference = array('pagine','id_navigation');
		$this->_onDelete = 'nocheck';
		parent::__construct();
	}

}