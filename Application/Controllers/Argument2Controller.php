<?php

class Argument2Controller extends Controller {

	function action1($arg1 = 1, $arg2 = 'ciao') {
		echo 'You have passed the argument ' . $arg1 .'<br />';
		echo 'You have also passed the argument '.$arg2 .'<br />';

		echo '<a href="'.$this->baseUrl.'/argument2/action2/'.$arg1.'/'.$arg2.'">Go to the action2</a>';
	}

	function action2($arg1 = 1, $arg2 = 'ciao') {
		echo 'You have passed the argument ' . $arg1 .'<br />';
		echo 'You have also passed the argument '.$arg2 .'<br />';

		echo '<a href="'.$this->baseUrl.'/argument2/action1/'.$arg1.'/'.$arg2.'">Go to the action1</a>';
	}

}

?>