<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class UsersModel extends Model_Tree {

	public function __construct() {
		$this->_tables='adminusers';
		$this->_idFields='id_user';
// 		$this->_where=array('id_group'=>'admingroups','id_user'=>'adminusers','name'=>'admingroups');
		$this->_popupItemNames = array('id_group'=>'name');
		$this->orderBy = 'adminusers.id_user desc';
		
// 		$this->on = "adminusers.id_user=adminusers_groups.id_user and admingroups.id_group=adminusers_groups.id_group";
		
		parent::__construct();
	}

}
