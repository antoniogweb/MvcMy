<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PagesModel extends Model_Tree {

	public function __construct() {
		
		$this->_tables='pages';
		$this->_idFields='id_page';
		
		$this->_idOrder = 'id_order';
		
		parent::__construct();
	}

}