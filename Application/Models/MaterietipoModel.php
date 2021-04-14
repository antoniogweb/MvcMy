<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class MaterietipoModel extends Model_Tree {

	public function __construct() {
		$this->_tables='MaterieTipo';
		$this->_idFields='Id_MaterieTipo';
		
		parent::__construct();
	}

}
