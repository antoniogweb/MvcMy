<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class GroupsModel extends Model_Tree {

	public function __construct() {
		$this->_tables='admingroups';
		$this->_idFields='id_group';
// 		$this->_where=array('id_user'=>'adminusers');
// 		$this->_popupItemNames=array('id_user'=>'username');
// 		$this->orderBy = 'admingroups.id_group desc';
		parent::__construct();
	}

}
