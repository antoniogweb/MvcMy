<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class TryModel extends Model_Tree {

	public function __construct() {
		$this->_tables='pagine';
		$this->_idFields='id_pagine';
		$this->_where=array('titolo'=>'pagine','id_navigation'=>'pagine');
		$this->_popupItemNames=array('titolo'=>'titolo','id_navigation'=>'id_navigation');
		$this->orderBy = 'id_pagine desc';
		parent::__construct();
	}

}