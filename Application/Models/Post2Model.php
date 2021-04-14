<?php

class PostModel extends Model_Tree {

	public function __construct() {
		//in the $_tables property you have to set the name of the table. post in this case
		$this->_tables='post';
		//in the $_idFields property you have to set the primary key of the table. In this case id
		$this->_idFields='id';
		//the $_where property is necessary to define the where clause.
		$this->_where=array('id' => 'post');
		//in the orderBy property you have to set the order by clause of all the select queries.
		//in this case we have specified that all the data retrieved from the post table have to be ordered using the index id for sorting (desc is for decreasing)
		$this->orderBy = 'id desc';
		//the $_onDelete property has to be set to 'nocheck' if you are working on a single table.
		$this->_onDelete = 'nocheck';
		//the followind instruction is necessary to call the parent __construct method
		parent::__construct();
	}

}

?>