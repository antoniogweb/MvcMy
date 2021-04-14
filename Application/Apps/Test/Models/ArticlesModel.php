<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class ArticlesModel extends Model_Tree {

	public function __construct() {
		$this->_tables='articles';
		$this->_idFields='id';
// 		$this->_where=array('id'=>'articles','n!author'=>'articles','category'=>'articles');
		$this->_popupItemNames=array('n!author'=>'author','category'=>'category');
		
		$this->_popupOrderBy = array(
			'n!author'=>'author',
		);
// 		$this->_popupWhere = array('category'=>'category = "cultura"');
		$this->orderBy = 'id desc';
// 		$this->_reference = array('pagine','id_navigation');
		$this->_onDelete = 'nocheck';
		$this->_lang = 'It';
		
		$this->foreignKeys = array(
			"id_navigation child of CategoriesModel(id_navigation) on update restrict ()"
		);
		
// 		$this->_fields = "if present title is not empty";
		
		parent::__construct();
	}

}