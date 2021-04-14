<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class BoxModel extends Model_Tree {

	public function __construct() {
		$this->_tables='boxes';
		$this->_idFields='id';
// 		$this->_where=array('title' => 'boxes');
		$this->_popupItemNames=array('id' => 'title');
		$this->orderBy = 'id desc';
		$this->_lang = 'It';
// 		$this->_onDelete = 'nocheck';
		parent::__construct();
	}

}