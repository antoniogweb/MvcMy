<?php

class Controller extends Controller {

	function main() {
		//load the first_view_file.php file by means of the load method of the controller
		$this->load('first_view_file');
		//load a second View file by means of the load method
		$this->load('second_view_file');
	}

}

?>