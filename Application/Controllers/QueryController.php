<?php

class QueryController extends Controller
{

	function __construct($model, $controller, $queryString)
	{
		parent::__construct($model, $controller, $queryString);

		$this->model('PostModel');

	}

	function action1()
	{
		$data = $this->m['PostModel']->query('select titolo from post;');
// 		$data = $this->m['PostModel']->query('desc post;');
// 		$data = $this->m['PostModel']->query('delete from post where id=65;');
// 		var_dump($data);
		echo '<pre>';
		print_r($data);
		echo '</pre>';
// 		echo get_resource_type($data).'<br />';
	}

}
