<?php

class Auto2Controller extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
        //create the associative array of the autoarguments
        //the values of the array are the default values of the autoarguments
		$autoArgs = array('arg1' => 1,'arg2' => 'Hello');
		$this->setArgKeys($autoArgs);
	}

	function action1() {
		//create the $this->viewArgs associative array
		$this->shift();
		echo 'You have passed the argument ' . $this->viewArgs['arg1'] .'<br />';
		echo 'You have also passed the argument '.$this->viewArgs['arg2'] .'<br />';

		echo 'autoarguments stack: '.$this->viewStatus;
	}

	function action2($suppl_arg = 'new') {
		//shift the arguments stack by one element and create the $this->viewArgs associative array
		$this->shift(1);
		echo 'The supplementary argument is '. $suppl_arg. '<br />';
		echo 'You have passed the argument ' . $this->viewArgs['arg1'] .'<br />';
		echo 'You have also passed the argument '.$this->viewArgs['arg2'] .'<br />';

		echo 'autoarguments stack: '.$this->viewStatus;
	}

}

?>