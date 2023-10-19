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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!defined('EG')) die('Direct access not allowed!');

class LogmailModel extends GenericModel
{
	public $password = null;
	
	public function __construct() {
		$this->_tables = 'log_email';
		$this->_idFields = 'id_log_mail';
		
		parent::__construct();
	}
	
	public function relations() {
        return array(
			'azienda' => array("BELONGS_TO", 'AziendeModel', 'id_azienda',null,"CASCADE"),
        );
    }
    
    public function data_creazione($row)
    {
		return date("d/m/Y H:i", strtotime($row["log_email"]["data_creazione"]));
    }
    
    public function oggetto($record)
    {
		return "<a id-riga='".$record["log_email"]["id_log_mail"]."' class='action_iframe iframe' href='".Url::getRoot()."logmail/form/update/".$record["log_email"]["id_log_mail"]."?partial=Y&nobuttons=Y&report=Y'>".$record["log_email"]["oggetto"]."</a>";
    }
    
    public function inviata($record)
    {
		if ($record["log_email"]["inviata"] != "No" && $record["log_email"]["inviata"] != "N")
			return "<span title='La mail è stata inviata correttamente' class='badge badge-primary'><i class='fa fa-thumbs-up'></i></span>";
		else
			return "<span title='Errore: la mail non è mai stata inviata' class='badge badge-danger'><i class='fa fa-thumbs-down'></i></span>";
    }
	
	public function insert()
	{
		$res = parent::insert();
		
		if ($res)
		{
			return $this->mandaIdMail($this->lId);
		}
		
		return false;
	}
	
	public function mandaIdMail($id)
	{
		require_once ROOT.'/External/PHPMailer-master/src/Exception.php';
		require_once ROOT.'/External/PHPMailer-master/src/PHPMailer.php';
		require_once ROOT.'/External/PHPMailer-master/src/SMTP.php';
		
		$email = $this->selectId((int)$id);
		
		if (!empty($email))
		{
			$mail = new PHPMailer(true); //New instance, with exceptions enabled
			
			try {
			
				if (ImpostazioniModel::$valori["smtp_host"])
				{
					$mail->IsSMTP();                         // tell the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->Port       = ImpostazioniModel::$valori["smtp_port"];                    // set the SMTP server port
					$mail->Host       = ImpostazioniModel::$valori["smtp_host"]; 		// SMTP server
					$mail->Username   = ImpostazioniModel::$valori["smtp_user"];     // SMTP server username
					$mail->Password   = ImpostazioniModel::$valori["smtp_psw"];            // SMTP server password
				}
				
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				$mail->setFrom(ImpostazioniModel::$valori["smtp_from"], ImpostazioniModel::$valori["smtp_nome"]);
				$mail->addAddress($email["inviata_a"], $email["inviata_a_nome"]);
				$mail->CharSet = 'UTF-8';
				if (ImpostazioniModel::$valori["bcc"])
					$mail->addBCC(ImpostazioniModel::$valori["bcc"]);
				
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = htmlentitydecode($email["oggetto"]);
				$mail->Body    = htmlentitydecode($email["testo"]);
				$mail->AltBody = 'Si prega di utilizzare un client di posta che supporti il codice HTML';
// 				$mail->SMTPDebug = 2;
				$mail->send();
				
				$this->setValues(array(
					"inviata"	=>	"Y",
				));
				
				if ($this->password)
					$this->setValue("testo", str_replace("Password: ".$this->password,"Password: XXXXXXXX",htmlentitydecode($email["testo"])));
				
				$this->update((int)$id);
				
				return true;
				
			} catch (Exception $e) {
				
			}
		}
		
		return false;
	}
}
