<?php

if (!defined('EG')) die('Direct access not allowed!');

class UsersgroupsModel extends GenericModel {
	
	public function __construct() {
		$this->_tables='adminusers_groups';
		$this->_idFields='id_ug';
		
		$this->orderBy = 'id_order desc';
		
		$this->_lang = 'It';
		$this->_idOrder = 'id_order';
		
		parent::__construct();
	}
	
	public function insert()
	{
		$clean["id_user"] = (int)$this->values["id_user"];
		$clean["id_group"] = (int)$this->values["id_group"];
		
		$u = new UsersModel();
		
		$ng = $u->clear()->from("admingroups")->select("*")->where(array("n!admingroups.id_group"=>$clean["id_group"]))->rowNumber();
		
		if ($ng > 0)
		{
			$res3 = $this->clear()->where(array("id_group"=>$clean["id_group"],"id_user"=>$clean["id_user"]))->send();
			
			if (count($res3) > 0)
			{
				$this->notice = "<div class='alert'>Questo utente è già stato associato a questo gruppo</div>";
			}
			else
			{
				$ngu = $this->select("*")->where(array("id_user"=>$clean["id_user"]))->rowNumber();
				
// 				if ($ngu === 0)
// 				{
					return parent::insert();
// 				}
// 				else
// 				{
// 					$this->notice = "<div class='alert'>Un utente non può essere associato a più di un gruppo.</div>";
// 				}
			}
		}
		else
		{
			$this->notice = "<div class='alert'>Questo elemento non esiste</div>";
		}
	}
	
}