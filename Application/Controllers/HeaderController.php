<?php

class HeaderController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		//load the header file
		$this->load('header_view_file');
		//load the footer view file (the last argument is necessary to load the footer file for last)
		$this->load('footer_view_file','last');
	}

	function main() {
		//load the view file of the main action
		$this->load('main_view_file');
	}

	function form() {
		//load the view file of the form action
		$this->load('form_view_file');
	}

}

?>