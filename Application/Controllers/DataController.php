<?php

class DataController extends Controller {

	public function main()
	{
		$name = 'John';
		$text = 'Some text';
		//create the $data associative array
		//the keys of the $data array have to be equal to the name of the $variables
		$data['name'] = $name;
		$data['text'] = $text;
		//the set method is necessary to pass the $data array to all the view files that will be loaded
		$this->set($data);
		//load the view file
		$this->load('view_data');
	}

}

?>