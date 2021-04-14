<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class UsersController extends Controller {

	protected $fields; //fields for the update or insert query
	protected $values; //value for the update or insert query
// 	protected $_array; //instance of utilities_array

	function __construct($model, $controller, $queryString) {
		parent::__construct($model, $controller, $queryString);

		$this->argKeys = array('page','field','value');

		$this->helper('ArrayHelper');
		$this->session('admin');

		$this->fields = 'username';
		$this->values = $this->h['ArrayHelper']->subset($_POST,$this->fields,'sanitizeAll');

		$this->load('header');
		$this->load('footer','last');
	}

	public function login() {
		$data['action'] = url::getRoot('users/login');

		$this->s['admin']->checkStatus();
		if ($this->s['admin']->status['status']=='logged') { //check if already logged
			$this->s['admin']->redirect('logged');
		} else {
			if (isset($_POST['username']) and isset($_POST['password'])) {
				$this->s['admin']->login(sanitizeAll($_POST['username']),$_POST['password']);
			}
		}
		$this->set($data);
		$this->load('login');
	}

	public function logout() {
// 		print_r($this->s['admin']->status);
		$res = $this->s['admin']->logout();
		if ($res == 'not-logged') {
			$data['notice'] = "<div class='alert'>You can't logout because you are not logged..</div>\n";

		} else if ($res == 'was-logged') {
			$data['notice'] = "<div class='executed'>Logut executed successfully!</div>\n";

		} else if ($res == 'error') {

		}

		$data['login'] = url::getRoot('users/login');
		$this->set($data);
		$this->load('logout');
	}

	public function retype() {
		echo 'retype your password please';
	}

	public function view($page = 1, $field = null, $value = null) { //view all the users
		$this->_users->check('root');

		$this->shift(0);

		//top menù
		$viewArgs = array('page'=>$page,'field'=>$field,'value'=>$value);
		$this->helper('MenuHelper',$this->_controller,'panel/main');
		$data['topMenu'] = $this->h['MenuHelper']->render('panel,add');

		//page list
		$this->helper('PageDivisionHelper',"users/view",'page');
		$recordNumber = $this->m['UsersModel']->recordNumber('Items',$field,$value);
		$limit = $this->h['PageDivisionHelper']->getLimit($page,$recordNumber,5);
		$data['pageList'] = $this->h['PageDivisionHelper']->render((int)($page-2),5);

		$data['groups_data'] = $this->m['UsersModel']->getAll('Boxes');

		//list of items
		$this->helper('ListHelper');
		$this->h['ListHelper']->addItem('simpleText',';adminUsers:username;');
		$this->h['ListHelper']->addItem('simpleLink','/users/update/;adminUsers:id_user;','','Edit');
		$this->h['ListHelper']->addItem('delForm','users/del','adminUsers:id_user');

		$values = $this->m['UsersModel']->getAll('Items',$field,$value,$limit);
		$data['htmlList'] = $this->h['ListHelper']->render($values);

		$this->set($data);
		$this->load('topmenu');
		$this->load('view');
	}

	public function update($id = '') {
		$this->_users->check('root');

		$this->shift(1);

		$data['notice'] = null;

		if (isset($_POST['scelta'])) {
			if ($this->h['ArrayHelper']->checkEmpty($_POST,$this->fields)) {
				if ($this->h['ArrayHelper']->checkEmpty($_POST,'password,confirmation')) {
					if ($this->h['ArrayHelper']->checkEqual($_POST,'password,confirmation')) {
						$valuesPlus = array('password'=>md5($_POST['confirmation']));
						if ($this->m['UsersModel']->update('adminUsers',$this->fields.',password',array_merge($this->values,$valuesPlus),"id_user=".(int)$id)) {
							$data['notice'] = "<div class='executed'>Changes applied!</div>\n";

						} else {
							$data['notice'] = "<div class='alert'>User already present!</div>\n";

						}
					} else {
						$data['notice'] = "<div class='alert'>Different passwords!</div>\n";

					}
				} else {
					if ($_POST['password'] == '' and $_POST['confirmation'] == '') {
						if ($this->m['UsersModel']->update('adminUsers',$this->fields,$this->values,"id_user=".(int)$id)) {
							$data['notice'] = "<div class='executed'>Changes applied!</div>\n";

						} else {
							$data['notice'] = "<div class='alert'>User already present!</div>\n";

						}
					} else {
						$this->h['ArrayHelper']->checkEmpty($_POST,'password,confirmation');
						$data['notice'] = $this->h['ArrayHelper']->errorString;

					}
				}
			} else {
				$data['notice'] = $this->h['ArrayHelper']->errorString;

			}
		}

// 		$viewArgs = array('page'=>$page,'field'=>$field,'value'=>$value);
		$this->helper('MenuHelper',$this->_controller,'panel/main');

		$data['viewStatus'] = $this->viewStatus;

		$users = $this->m['UsersModel']->getAll('Items','id_user',(int)$id);
		$data['values'] = $users[0]['adminUsers'];
		$data['action'] = url::getRoot("users/update/$id".$data['viewStatus']);
		$data['topMenu'] = $this->h['MenuHelper']->render('panel,back');

		$this->set($data);
		$this->load('topmenu');
		$this->load('notice');
		$this->load('form');
	}

	public function add() {
		$this->_users->check('root');

		$this->shift(0);

		$this->helper('MenuHelper',$this->_controller,'panel/main');

		$data['viewStatus'] = $this->viewStatus;

		$flag = 1;

		$data['notice'] = null;
		if (isset($_POST['scelta'])) {
			if (!$this->m['UsersModel']->recordExists('adminUsers','username',$this->values['username'])) {
				if ($this->h['ArrayHelper']->checkEmpty($_POST,$this->fields.',password,confirmation')) {
					if ($this->h['ArrayHelper']->checkEqual($_POST,'password,confirmation')) {
						$valuesPlus = array('password'=>md5($_POST['confirmation']));
						if ($this->m['UsersModel']->insert('adminUsers',$this->fields.',password',array_merge($this->values,$valuesPlus))) {
							$data['notice'] = "<div class='executed'>New user inserted!</div>\n";
							$flag = 2;
							//set the base group
// 							$this->UsersModel->orderBy=null;
// 							$group = $this->UsersModel->getAll('Boxes','name','base');
// 							if ($this->UsersModel->associate(mysql_insert_id(),$group[0]['id_group'])) {
// 								$this->set('notice',"<div class='executed'>New user inserted!</div>\n");
// 							} else {
// 								$this->set('notice',"<div class='alert'>Query error! Group 'base' not inserted! Contact the administrator!</div>\n");
// 							}
						} else {
							$data['notice'] = "<div class='alert'>Query error: User not inserted! Contact the administrator!</div>\n";

						}
					} else {
						$data['notice'] = $this->h['ArrayHelper']->errorString;

					}
				} else {
					$data['notice'] = $this->h['ArrayHelper']->errorString;

				}
			} else {
				$data['notice'] = "<div class='alert'>Username already present!</div>\n";

			}
		}

		$data['values'] = $this->h['ArrayHelper']->subset($_POST,$this->fields,'sanitizeHtml');
		$data['action'] = url::getRoot("users/add".$data['viewStatus']);
		$data['topMenu'] = $this->h['MenuHelper']->render('panel,back');

		$this->set($data);
		$this->load('topmenu');
		$this->load('notice');
		if ($flag == 1) $this->load('form');
	}

	public function del() {
		$this->_users->check('root');

		$this->shift(0);

// 		$viewArgs = array('page'=>$page,'field'=>$field,'value'=>$value);
		$this->helper('MenuHelper',$this->_controller,'panel/main');

		$data['notice'] = null;

		if (isset($_POST['delAction'])) {
			$id = (int)sanitizeAll($_POST['id']);
			$associatedUsers = $this->m['UsersModel']->checkAssociation($id);
			if (empty($associatedUsers)) {
				$this->m['UsersModel']->del('adminUsers',"id_user=".$id);
				$data['notice'] = "<div class='executed'>Users deleted!</div>\n";
			} else {
				$data['notice'] = "<div class='alert'>User associated to some group!</div>\n";
			}
		}

// 		if (isset($_POST['delete'])) {
// 			$values = $this->h['ArrayHelper']->subsetDifference($_POST,'delete','sanitizeAll');
// 			if (!empty($values)) {
// 				$associatedUsers = $this->m['UsersModel']->checkAssociation($values);
// 				if (empty($associatedUsers)) {
// 					$whereString = 'id_user in ('.implode(',',$values).')';
// 					if ($this->m['UsersModel']->del('adminUsers',$whereString)) {
// 						$data['notice'] = "<div class='executed'>Users deleted!</div>\n";
// 
// 					} else {
// 						$data['notice'] = "<div class='alert'>Query error: Users not deleted! Contact the administrator!</div>\n";
// 
// 					}
// 				} else {
// 					$data['notice'] = "<div class='alert'>Users associated to some group!</div>\n";
// 
// 				}
// 			} else {
// 				$data['notice'] = "<div class='alert'>No users selected!</div>\n";
// 
// 			}
// 		}
		$data['topMenu'] = $this->h['MenuHelper']->render('panel,back');
		$this->set($data);
		$this->load('topmenu');
		$this->load('notice');
	}

}