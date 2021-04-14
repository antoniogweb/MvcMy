<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class LateralController extends Controller {

// 	public function __construct($model, $controller, $queryString) {
// 		parent::__construct($model, $controller, $queryString);
// 		$this->load('header');
// 		$this->load('footer','last');

// 		$this->model();
// 		$this->m['PostModel']->setFields('titolo,autore,testo','sanitizeAll');
// 		$this->m['PostModel']->validateConditions['update'] = 'checkNotEmpty:titolo,testo;checkDigit:titolo';
// 		$this->m['PostModel']->validateConditions['insert'] = 'checkAlphaNum:titolo';
// 
// 		$this->m['PostModel']->databaseConditions['insert'] = 'checkUnique:titolo';
// 		$this->m['PostModel']->databaseConditions['update'] = 'checkUniqueCompl:titolo';
// 
// 		$this->setArgKeys(array('page:forceInt'=>1,'field:sanitizeAll'=>'all','value:sanitizeAll'=>1));
// 		$data2['ciao'] = 'ciao';
// 		$this->set($data2);
// 	}

	public function index() {
		$data['var1'] = 'example1';
		$this->append($data);
		$this->load('lateral');
	}

}