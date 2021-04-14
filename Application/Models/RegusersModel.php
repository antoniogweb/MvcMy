<?php

if (!defined('EG')) die('Direct access not allowed!');

class RegusersModel extends Model_Tree {

	public function __construct() {
		$this->_tables='regusers';
		$this->_idFields='id_user';
		
		$this->orderBy = 'regusers.id_user desc';
		$this->_lang = 'It';

		$this->_popupItemNames = array(
			'has_confirmed'	=>	'has_confirmed',
			'tipo_cliente'	=>	'tipo_cliente',
		);

		$this->_popupLabels = array(
			'has_confirmed'	=>	'ATTIVO?',
			'tipo_cliente'	=>	'TIPO CLIENTE',
		);

		$this->_popupFunctions = array(
			'has_confirmed'	=>	'getYesNoUtenti',
		);
		
		parent::__construct();

		$this->addStrongCondition("both",'checkMail',"username|Si prega di ricontrollare il campo Email<div rel='hidden_alert_notice' style='display:none;'>username</div>");
		$this->addStrongCondition("insert",'checkNotEmpty',"password,confirmation");
		$this->addSoftCondition("both",'checkEqual',"password,confirmation|Le due password non coincidono<div rel='hidden_alert_notice' style='display:none;'>password</div><div rel='hidden_alert_notice' style='display:none;'>confirmation</div>");

		$this->addDatabaseCondition("both",'checkUnique',"username|Il valore del campo Email è già usato da un altro cliente, si prega di sceglierne un altro<div rel='hidden_alert_notice' style='display:none;'>username</div>");

	}
	
	public function relations() {
        return array(
			'groups' => array("MANY_TO_MANY", 'ReggroupsModel', 'id_group', array("RegusersgroupsModel","id_user","id_group"), "CASCADE"),
        );
    }
	
}
