<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class SupplModel extends Model_Tree {

	public function __construct() {
		$this->_tables='navigation';
		$this->_idFields='id_navigation';
		$this->_where=array('id_navigation'=>'navigation');
		$this->_popupItemNames=array();
		$this->orderBy = 'id_ordinamento desc';
		$this->_reference = array('pagine','id_navigation');
		$this->_idOrder = 'id_ordinamento';
// 		$this->_onDelete = 'check';
		parent::__construct();
	}

}