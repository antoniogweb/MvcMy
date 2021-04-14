<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PagineModel extends Model_Tree {

	public function __construct() {
		$this->_tables='pagine';
		$this->_idFields='id_pagine';
		$this->_where=array('id_pagine'=>'pagine','-id_navigation'=>'navigation','-name'=>'pagine','name'=>'navigation','n!dayofmonth(pagine.time)'=>'pagine');
		$this->_popupItemNames=array('-id_navigation'=>'name','-name'=>'name');
		$this->orderBy = 'pagine.id_ordinamento desc';
		$this->_onDelete = 'nocheck';
		$this->_lang = 'It';
		$this->_idOrder = 'id_ordinamento';
		
// 		$this->foreignKeys = array(
// 			"id_navigation child of CategoryModel(id_navigation) on update restrict (Si prega di scegliere la categoria)",
// 		);
		
// 		$this->from = 'pagine';
// 		$this->on = '-';

		$this->formStruct = array
		(
			'entries' 	=> 	array(
// 				'name'	=> 	array(
// 					'labelString' => 'dd',
// 					'className'	=>	'uuu',
// 				),
				'id_navigation'	=>	array(
					'type'		=>	'Select',
					'options'	=>	'foreign::navigation::id_navigation,name::--::--::id_navigation desc',
					'reverse'	=>	'yes',
				),
				'titolo'		=>	array(
					'wrap'		=>	array(
						null,
						null,
						"<div>;;sha1|value;;</div>"
					),
				),
				'html'			=>	array(
					'className'	=>	'uuu',
				),
				'id_pagine'	=>	array(
					'type'		=>	'Hidden'
				),
				'immagine'	=>	array(
					'type'		=>	'File',
					'deleteButton'	=>	array('deleteFile','delete','deleteFile'),
					'wrap'		=>	array(
						null,
						null,
						"<div><img width='100px' src='http://".DOMAIN_NAME."/media/;;value;;'></div>"
					),
				),
				'bo'	=>	array(
					'type'	=>	'Radio',
					'options'	=>	'uno,due,tre'
				)
			),

			'enctype'	=>	'multipart/form-data',
		);
			
		parent::__construct();

		$this->files->setParam('allowedExtensions','');
		$this->files->setParam('fileUploadKey','immagine');
		$this->files->setParam('functionUponFileNane','none');
// 		$this->files->setParam('allowedMimeTypes','image/jpeg');
		$this->files->setParam('createImage',true);
	}

	public function relations() {
        return array(
			'categories' => array("BELONGS_TO", 'CategoryModel', 'id_navigation',null,"RESTRICT","Si prega di selezionare la categoria"),
        );
    }
    
	public static function strtolower($string)
	{
		return "[STATICO] $string";
	}
	
	public function strtolower3($string)
	{
		return "[DINAMICO] $string";
	}
	
// 	public function update($id = NULL, $whereClause = NULL)
// 	{
// 		if (isset($_FILES['immagine']["name"]) and strcmp($_FILES['immagine']["name"],'') !== 0)
// 		{
// // 			$this->files->setParam('fileUploadBehaviour','add_token');
// // 			$this->files->setParam('fileUploadBeforeTokenChar','-');
// 			if ($this->files->uploadFile())
// 			{
// 				$this->values['immagine'] = sanitizeAll($this->files->fileName);
// 				$result = parent::update($id);
// 
// 				$list = $this->select()->toList('immagine')->send();
// 				$this->files->removeFilesNotInTheList($list);
// 
// 				return $result;
// 			}
// 			else
// 			{
// 				$this->notice = $this->files->notice;
// 				$this->result = false;
// 			}
// 		}
// 		else
// 		{
// 			return parent::update($id);
// 		}
// 	}

// 	public function insert()
// 	{
// 		if ($this->files->uploadFile())
// 		{
// 			$clean['fileWithExt'] = sanitizeAll($this->files->fileName);
// 			$this->values['immagine'] = $clean['fileWithExt'];
// 			parent::insert();
// 		}
// 		else
// 		{
// 			$this->notice = $this->files->notice;
// 			$this->result = false;
// 		}
// 	}

// 	public function del($id = NULL, $whereClause = NULL)
// 	{
// 		$record = $this->selectId((int)$id);
// 		if ( strcmp($record['immagine'],'') !== 0 and parent::del($id) )
// 		{
// 			$this->files->removeFile($record['immagine']);
// 		}
// 	}

}
