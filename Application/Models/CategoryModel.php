<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class CategoryModel extends Model_Tree {

	public function __construct() {
		$this->_tables='navigation';
		$this->_idFields='id_navigation';
// 		$this->_where=array('id_navigation'=>'navigation','name'=>'navigation');
// 		$this->_popupItemNames=array('name'=>'name');
// 		$this->orderBy = 'id_ordinamento desc';
// 		$this->_onDelete = 'check';
// 		$this->_reference = array('pagine','id_navigation');
		
// 		$this->foreignKeys = array(
// 			"id_navigation parent of PagineModel(id_navigation) on delete restrict (la categoria non è vuota)",
// // 			"id_navigation parent of PagineModel(id_navigation) on delete cascade (sono state cancellate anche tutte le pagine figlie di questa categoria)",
// 		);
		
// 		$this->_lang = 'It';
		$this->_idOrder = 'id_ordinamento';

// 		$this->_onDelete = 'check';
		parent::__construct();

// 		$this->setString('associate','<div class="alert">la categoria non &egrave vuota</div>');
	}

	public function relations() {
        return array(
			'pages' => array("HAS_MANY", 'PagineModel', 'id_navigation', null, "RESTRICT", "La categoria contiene delle pagine"),
        );
    }
    
	public static function test($string)
	{
		return "[static]".$string;
	}
	
	public function ntest($string)
	{
		return "[non-static]".$string;
	}
	
	public function fff($rSet)
	{
		return $rSet["navigation"]["id_navigation"]."-".$rSet["navigation"]["categoria"];
	}
}
