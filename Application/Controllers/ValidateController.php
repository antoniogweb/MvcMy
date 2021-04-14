<?php

class ValidateController extends Controller {

	function index() {
		
		$base = new Array_Validate_Base('It');
		
		$testArray = array('password'=>'ewr','confirmation'=>'wer');
		
// 		$base->checkEqual($testArray,'password,confirmation,hello');
		
// 		$base->checkMail($testArray,'password,confirmation,asdasd','strong');
		
		$base->checkIsNotStrings($testArray,'password,confirmation,asdasd','ciao,bello');
		
		echo $base->errorString;
		echo "It works!";
		
	}
	
	function strong()
	{
		$strong = new Array_Validate_Strong('It');
		
		$testArray = array('password'=>'123.123','confirmation'=>'12321');
		
// 		$strong->checkNotEmpty($testArray,'password,confirmation');
		
		$strong->checkNumeric($testArray,'password,confirmation');
		
// 		$strong->checkLength($testArray,'password,confirmation',8);
		
// 		$strong->checkIsStrings($testArray,'password,confirmation','ciao,23');
		
		echo $strong->errorString;
		echo "It works!";
		
	}
	
	function soft()
	{
		$soft = new Array_Validate_Soft('It');
		
		$testArray = array('password'=>'2234.234234','confirmation'=>'');
		
		$soft->checkNotEmpty($testArray,'password,confirmation');
		$soft->checkNumeric($testArray,'password,confirmation');
// 		$soft->checkLength($testArray,'password,confirmation',8);
// 		$soft->checkIsStrings($testArray,'password,confirmation','ciao,23');
// 		$soft->checkIsNotStrings($testArray,'password,confirmation','ciao,23');
		
		echo $soft->errorString;
		echo "It works!";
	}

}