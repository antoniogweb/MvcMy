<?php

// MvcMy is a flexible and easy-to-use PHP MVC framework to use together with MvcMyLibrary
// Copyright (C) 2009 - 2023  Antonio Gallo (info@laboratoriolibero.com)
// See LICENSE.txt.
// 
// This file is part of MvcMy
// 
// MvcMy is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// MvcMy is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with MvcMy.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

class UtentiController extends BaseController {
	
	public $argKeys = array('email:sanitizeAll'=>'tutti', 'id_permesso:sanitizeAll'=>'tutti');
	
	public $sezionePannello = "impostazioni";
	
	function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);

		$this->model("UtentipermessiModel");
		$this->model("PermessiModel");
	}

	public function login()
	{
		$redirect = "";
		$modulo = "";
		
		if (isset($_GET["modulo"]))
		{
			if (isset(LicenzeModel::$tipi[$_GET["modulo"]]))
			{
				$redirect = "?modulo=manutenzioni";
				$modulo = LicenzeModel::$tipi[$_GET["modulo"]];
			}
		}
		
		$data['action'] = $this->baseUrl."/utenti/login".$redirect;
		$data['notice'] = null;
		
		$redirectUrl = "panel/main";

		if ($modulo)
			$redirectUrl = $modulo;
			
		$this->s['admin']->checkStatus();
		if ($this->s['admin']->status['status']=='logged') { //check if already logged
			$this->redirect('panel/main',0);
		}
		
		if (isset($_POST["recuperaPassword"]) and isset($_POST["email"]))
		{
			if (checkMail($_POST["email"]))
			{
				$data['notice'] = $this->m["UtentiModel"]->recuperaPassord($_POST["email"], PIATTAFORMA);
			}
			else
			{
				$data['notice'] = "<div class='alert alert-danger'>Si prega di controllare l'indirizzo email</div>";
			}
		}
		
		if (isset($_POST['email']) and isset($_POST['password']))
		{
			$choice = $this->s['admin']->login(sanitizeAll($_POST['email']),$_POST['password']);
			
			if(!isset($_SESSION))
				session_start();
			
			switch($choice) {
				case 'logged':
					$this->redirect('panel/main');
					break;
				case 'accepted':
					
					$id_utente = (int)$this->s['admin']->status['id_user'];
					$this->model("AccessiModel");
					$this->m["AccessiModel"]->salvaAccesso($id_utente);
					
					$this->redirect($redirectUrl,0);
					break;
				case 'login-error':
					$data['notice'] = '<div class="alert alert-danger">'.t("Username o password sbagliati").'</div>';
					break;
				case 'wait':
					$data['notice'] = '<div class="alert alert-danger">'.t("Devi aspettare 5 secondi prima di poter eseguire nuovamente il logi").'n</div>';
					break;
			}
		}
		
		$this->append($data);
		$this->load('login');
	}
	
	public function logout() {
		$this->clean();
		$res = $this->s['admin']->logout();
		if ($res == 'not-logged') {
			header('Refresh: 0;url='.$this->baseUrl);

		} else if ($res == 'was-logged') {
			header('Refresh: 0;url='.$this->baseUrl);

		} else if ($res == 'error') {

		}
	}
	
	public function main()
	{
		$this->s["admin"]->check("Admin");
		
		$this->shift();
		
		$this->mainButtons = 'ldel,ledit';
		$this->mainFields = array("[[ledit]];utenti.email;","utenti.nome","utenti.cognome", "UtentiModel.listaGruppi|utenti.id_utente", "UtentiModel.pulsanteAttiva|utenti.id_utente");
		$this->mainHead = "Email,Nome,Cognome,Gruppi,";
		
		$filtroPermessi = array("tutti"	=>	"Permesso") + $this->m["PermessiModel"]->clear()->orderBy("titolo")->toList("id_permesso", "titolo")->send();
		
		$this->filters = array(array("attivo",null,$this->filtroAttivo),array("id_permesso",null,$filtroPermessi),"cerca");
		
// 		$this->bulkQueryActions = "del,attiva,disattiva";
		
// 		$this->bulkActions = array(
// // 			"checkbox_utenti_id_utente"		=>	array("del","Elimina selezionati","confirm"),
// 			" checkbox_utenti_id_utente"	=>	array("attiva","Attiva selezionati"),
// 			"  checkbox_utenti_id_utente"	=>	array("disattiva","Disattiva selezionati")
// 		);
		
		$this->m[$this->modelName]->clear()
				->select("utenti.*")
				->where(array(
					"lk" => array('utenti.email' => $this->viewArgs['cerca']),
					'utenti.attivo'	=>	$this->viewArgs['attivo'],
				))
				->groupBy("utenti.id_utente")
				->orderBy("utenti.id_utente desc")->convert();
		
		if (strcmp($this->viewArgs['id_permesso'],"tutti") !== 0)
		{
			$this->m[$this->modelName]->inner("utenti_permessi")->on("utenti.id_utente = utenti_permessi.id_utente")->aWhere(array(
				"utenti_permessi.id_permesso"	=>	$this->viewArgs['id_permesso'],
			));
		}
		
		$this->m[$this->modelName]->save();
		
		parent::main();
	}

	public function form($queryType = 'insert', $id = 0)
	{
		$this->s["admin"]->check("Admin");
		
		$clean['id'] = (int)$id;
		
		$this->_posizioni['form'] = 'class="active"';
		
		$this->shift(2);
		
		$this->m[$this->modelName]->setFields('email:sanitizeAll,attivo:sanitizeAll,nome:sanitizeAll,cognome:sanitizeAll,password','none');
		$this->formFields = 'email,attivo,nome,cognome,password,confirmation';
		
		$this->m[$this->modelName]->inserisciPermesso = 2; //forza l'inserimento del permesso Accettazione
		
		parent::form($queryType, $id);
		
		if (strcmp($queryType,'update') === 0)
		{
			$data['id_utente'] = $clean['id'];
			$data["titoloPagina"] = $this->m[$this->modelName]->where(array("id_utente"=>$clean['id']))->field("email");
			$data['numeroGruppi'] = $this->m["UtentipermessiModel"]->where(array("id_utente"=>$clean['id']))->rowNumber();
			
			$this->append($data);
		}
	}
	
	public function permessi($id = 0)
	{
		$this->s['admin']->check("Admin");
		
		$this->_posizioni['permessi'] = 'class="active"';
		
// 		$data["orderBy"] = $this->orderBy = "id_order";
		
		$this->shift(1);
		
		$clean['id'] = $this->id = (int)$id;
		$this->id_name = "id_utente";
		
		$this->m[$this->modelName]->check($clean['id']);
		
		$this->mainButtons = "ldel";
		
		$this->modelName = "UtentipermessiModel";
		
		$this->m[$this->modelName]->setFields('id_permesso','sanitizeAll');
		$this->m[$this->modelName]->values['id_utente'] = $clean['id'];
		$this->m[$this->modelName]->updateTable('insert');
		
		$this->mainFields = array("permessi.titolo");
		$this->mainHead = "PERMESSO";
		
		$this->scaffoldParams = array('recordPerPage'=>2000000,'mainMenu'=>'back','mainAction'=>"permessi/".$clean['id'],'pageVariable'=>'page_fgl');
		
		$this->m[$this->modelName]->clear()->select("permessi.*,utenti_permessi.*")->inner("permessi")->using("id_permesso")->orderBy("permessi.titolo")->where(array("id_utente"=>$clean['id']))->convert()->save();
		
		parent::main();
		
		$data["listaPermessi"] = $this->m[$this->modelName]->clear()->from("permessi")->select("permessi.titolo,permessi.id_permesso")->orderBy("permessi.titolo")->toList("permessi.id_permesso","permessi.titolo")->send();
		
		$data['tabella'] = "utenti";
		
		$data["titoloRecord"] = $this->m["UtentiModel"]->where(array("id_utente"=>$clean['id']))->field("email");
		
		$this->append($data);
	}

}
