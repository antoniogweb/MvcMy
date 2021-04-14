<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class PanelController extends Controller {

	public function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);
		$this->session('admin');
		$this->load('header');
		$this->load('footer','last');
	}

	public function main()
	{
// 		$this->s['admin']->checkStatus();
// 		print_r($this->s['admin']->status);
		$this->s['admin']->check(null,1);
// 		echo $this->s['admin']->uid;
		$data['logged'] = $this->s['admin']->getUsersLogged();

		$id = (int)$this->s['admin']->status['id_user'];
		
		$name = $this->s['admin']->status['user'];
		
		$gruppi = $this->s['admin']->status['groups'];
		
// 		echo $id;
		print_r($gruppi);
		
		$token = $this->s['admin']->status['token'];
		$data['urlAdd'] = '/1/all/1/'.$token;

// 		print_r($this->s['admin']->status);
		
		$this->set($data);
		$this->load('panel');
	}

	public function index()
	{
		echo 'inside panel/index';
	}

}