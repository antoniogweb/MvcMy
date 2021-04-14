<?php

class ConstructController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		echo 'action carried oy by the construct method<br />';
	}

	function view() {
		echo 'inside the view action!';
	}

	function del() {
		echo 'inside the del action!';
	}

}

?>