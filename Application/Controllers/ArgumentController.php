<?php

class ArgumentController extends Controller {

	function view($arg = 1) {
		echo 'You have passed the argument ' . $arg . ' to the view action of the argument controller';
	}

}

?>