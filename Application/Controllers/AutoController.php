<?php

class AutoController extends Controller {

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$autoArgs = array('arg1' => 1,'arg2' => 'Hello');
		$this->setArgKeys($autoArgs);
		$this->shift();
	}

	function action1() {
		echo 'You have passed the argument ' . $this->viewArgs['arg1'] .'<br />';
		echo 'You have also passed the argument '.$this->viewArgs['arg2'] .'<br />';

		echo 'arguments stack: '.$this->viewStatus;
	}

	function action2() {
		echo 'You have passed the argument ' . $this->viewArgs['arg1'] .'<br />';
		echo 'You have also passed the argument '.$this->viewArgs['arg2'] .'<br />';

		echo 'arguments stack: '.$this->viewStatus;
	}

}

?>