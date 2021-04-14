<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PostModel extends MapModel {

	public function __construct() {
		$this->_tables='post,argomenti,arg_post';
		$this->_idFields='id,id_arg';
		$this->_where=array('id'=>'post','autore'=>'post','titolo'=>'post','id_arg'=>'argomenti');
		$this->_popupItemNames=array('autore'=>'autore','titolo'=>'titolo','id_arg'=>'title');
		$this->orderBy = array('Items' => 'post.id desc','Boxes' => 'argomenti.id_arg desc');
		parent::__construct();
	}

}