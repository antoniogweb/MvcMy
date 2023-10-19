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

class UtentiModel extends GenericModel {
	
	public $inserisciPermesso = null;
	
	public $applySoftConditionsOnPost = true;
	
	public function __construct() {
		$this->_tables='utenti';
		$this->_idFields='id_utente';
		
		$this->orderBy = 'utenti.id_utente desc';
		
		$this->_idOrder = 'ordine';
		
		$this->formStruct = array
		(
			'entries' 	=> 	array(
				'email'		=>	array(
					'attributes'	=> 'autocomplete="new-password"',
				),
				'password'			=>	array(
					'type'	=>	'Password',
					'attributes'	=> 'autocomplete="new-password"',
				),
				'confirmation'		=>	array(
					'labelString'	=>	'Conferma la password',
					'type'			=>	'Password',
					'attributes'	=> 'autocomplete="new-password"',
				),
			),
		);
		
		parent::__construct();
		
		$this->addStrongCondition("both",'checkMail',"email");
		$this->addStrongCondition("insert",'checkNotEmpty',"password,confirmation");
		$this->addSoftCondition("both",'checkEqual',"password,confirmation|Le due password non coincidono");
		
		$this->addDatabaseCondition("both",'checkUnique',"email|Il valore del campo email è già usato, si prega di sceglierne un altro<div rel='hidden_alert_notice' style='display:none;'>email</div>");
	}
	
	public function permessi($id)
	{
		$pu = new UtentipermessiModel();
		
		return $pu->select("permessi.titolo")->inner("permessi")->using("id_permesso")->where(array("id_utente"=>(int)$id))->toList("permessi.titolo")->send();
	}
	
	public function gestibile($id)
	{
		$permessi = $this->permessi($id);
		
		return in_array("Admin",$permessi) ? false : true;
	}
	
	public function titolo($id)
	{
		$clean["id"] = (int)$id;
		
		$record = $this->selectId($clean["id"]);
		
		if (!empty($record) and strcmp($record["email"],"") !== 0)
		{
			return $record["email"];
		}
		
		return "";
	}
	
	/**
	* @brief crea una password ed invia le credenziali al cliente
	* 
	* @param string $email email dell'account
	*
	* @return string the notice string
	*/
// 	public function invioCredenziali($email, $password = null)
// 	{
// 		$clean["email"] = sanitizeAll($email);
// 		
// 		if (checkMail($clean["email"]))
// 		{
// 			$utente = $this->clear()->where(array(
// 				"email"		=>	$clean["email"],
// 				"attivo"	=>	"Y",
// 			));
// 			
// 			$utente = $this->send();
// 			
// 			if (count($utente) > 0)
// 			{
// 				$clean["id_utente"] = (int)$utente[0]["utenti"]["id_utente"];
// 				
// 				$creazione = true;
// 				
// 				if (!$password)
// 				{
// 					$creazione = false;
// 					
// 					$password = generateString(8);
// 					
// 					$clean["password"] = sha256($password);
// 					
// 					$this->values = array(
// 						"password"	=>	$clean["password"],
// 						"email"		=>	sanitizeDb($utente[0]["utenti"]["email"]),
// 					);
// 					
// 					$this->pUpdate($clean["id_utente"]);
// 				}
// 				
// 				if ($password)
// 				{
// 					//mail con credenziali
// 					ob_start();
// 					include ROOT."/Application/Views/Utenti/mail_credenziali.php";
// 					$output = ob_get_clean();
// 					
// 					$lm = new LogmailModel();
// 					
// 					$lm->password = $password;
// 					
// 					$lm->setValues(array(
// 						"id_azienda"	=>	$utente[0]["utenti"]["id_azienda"],
// 						"inviata_a"		=>	$clean["email"],
// 						"inviata_a_nome"	=>	$utente[0]["utenti"]["nome"],
// 						"titolo"		=>	"Invio credenziali accesso",
// 						"oggetto"		=>	"Invio credenziali accesso piattaforma",
// 						"testo"			=>	$output,
// 					));
// 					
// 					if ($lm->insert())
// 					{
// 						if ($creazione)
// 							$this->notice = "<div class='alert alert-success'>L'account è stato creato e le credenziali sono state inviate all'utente</div>";
// 						else
// 							flash("notice","<div class='alert alert-success'>Le nuove credenziali sono state inviate all'utente</div>");
// 					}
// 				}
// 			}
// 			else
// 			{
// 				return "<div class='alert alert-danger'>Attenzione, l'indirizzo e-mail non corrisponde ad alcun utente attivo</div>";
// 			}
// 		}
// 	}
	
	public function insert()
	{
		$res = parent::insert();
		
		if ($res and isset($this->inserisciPermesso))
		{
			$up = new UtentipermessiModel();
			
			$up->setValues(array(
				"id_utente"		=>	$this->lId,
				"id_permesso"	=>	$this->inserisciPermesso,
			));
			
			$up->insert();
		}
		
		return $res;
	}
	
	public function update($id = null, $where = null)
	{
		$clean['id'] = (int)$id;
		
		if (isset($this->values['password']) and strcmp($this->values['password'],sha256('')) === 0)
		{
			$this->delFields('password');
		}
		
		$res =  parent::update($clean['id']);
		
		return $res;
	}
	
	public function del($id = null, $whereClause = null)
	{
		$clean['id'] = (int)$id;
			
		//cancello tutti i gruppi a cui è associato
		$ug = new UtentipermessiModel();
		$lug = $ug->clear()->where(array("id_utente"=>$clean['id']))->toList("id_utente_permesso")->send();
		
		foreach ($lug as $id_ug)
		{
			$ug->del($id_ug);
		}
		
		return parent::del($clean['id']);
	}

	public function listaGruppi($id)
	{
		$clean["id"] = (int)$id;
		
		$ug = new UtentipermessiModel();
		
		$gruppi = $ug->clear()->select("permessi.titolo")->inner("permessi")->using("id_permesso")->where(array("id_utente"=>$clean["id"]))->toList("permessi.titolo")->send();
		
		if (count($gruppi) > 0)
		{
			return implode("<br />",$gruppi);
		}
		
		return "- -";
	}
	
}
