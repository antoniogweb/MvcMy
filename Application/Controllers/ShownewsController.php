<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class ShownewsController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->model('NewsModel');
	}
	
	public function index()
	{
		$data['table'] = $this->m['NewsModel']->getAll('news');
		$this->append($data);
		$this->load('view');
// 		echo '<pre>';
// 		print_r($data);
// 		echo '</pre>';

	}

}