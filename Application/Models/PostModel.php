<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class PostModel extends Model_Map {

	public function __construct() {
		$this->_tables='post,argomenti,arg_post';
		$this->_idFields='id,id_arg';
		
		$this->_where = array(
			'-id'=>'post',
			'autore'=>'post',
			'titolo'=>'post',
			'-id_arg'=>'argomenti',
			'n!dayofmonth(post.time)'=>'post',
			'n!dayname(post.time)'=>'post',
			'n!monthname(post.time)'=>'post',
			'title'=>'argomenti'
		);
		
		$this->_popupItemNames = array(
			'autore'=>'autore',
			'-id'=>'titolo',
			'-id_arg'=>'title',
			'n!dayofmonth(post.time)'=>'n!dayofmonth(post.time)',
			'n!dayname(post.time)'=>'dayname(post.time)',
			'n!monthname(post.time)'=>'n!monthname(post.time)'
		);
		
		$this->_popupLabels = array(
			'n!dayofmonth(post.time)'=>'day of month',
			'n!dayname(post.time)'=>'day of week',
			'n!monthname(post.time)'=>'month'
		);
		
		$this->_popupOrderBy = array(
			'autore'=>'autore desc',
		);

		$this->_popupFunctions = array(
// 			'autore'=>'my_md5'
		);
		
		$this->orderBy = 'post.id_order desc';
		$this->_lang = 'It';
		$this->_idOrder = 'id_order';
		
		$this->on = "post.id=arg_post.id and argomenti.id_arg=arg_post.id_arg";
		
		parent::__construct();
	}
	
	

}
