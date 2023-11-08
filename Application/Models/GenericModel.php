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

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class GenericModel extends Model_Tree {
	
	public static $permettiSempreEliminazione = false;
	
	public $campiMostraDifferenzeRevisioni = null;
	public $arrayFunzioniSuDifferenze = array();
	public $arrayLabelCampiRevisioni = array();
	
	public $salvaRevisione = false;
	
	public static $arrayTitoli = array();
	
	public $campoTitolo = "titolo";
	
	public $uploadFields = array();
	public $lId = null;
	
	public $viewStatus = "";
	
	public $revisioneVisibile = "1";
	
	public function __construct() {

		parent::__construct();
		
		if (!empty($this->uploadFields))
		{
			$this->files->setParam('allowedExtensions','png,jpg,jpeg,gif');
			$this->files->setParam('maxFileSize',4000000);
			$this->files->setParam('functionUponFileNane','sanitizeFileName');
			$this->files->setParam('fileUploadBehaviour','add_token');
		}
	}
	
	public function bulkAction($bulk_list)
	{
		$bulkArray = explode(",",$bulk_list);
		
		if (isset($_POST["bulkAction"]) and isset($_POST["bulkActionValues"]))
		{
			if (in_array($_POST["bulkAction"],$bulkArray))
			{
				$action = $_POST["bulkAction"];
				
				if (method_exists($this,$action))
				{
					if (preg_match('/^[0-9]{1,}(\|[0-9]{1,})*$/',$_POST["bulkActionValues"]))
					{
						$bulkActionValuesArray = explode("|",$_POST["bulkActionValues"]);
						
						foreach ($bulkActionValuesArray as $bitem)
						{
							$this->$action($bitem);
						}
						
						return true;
					}
					else if (preg_match('/^[0-9]{1,}\:(.*){1,}(\|[0-9]{1,}\:(.*){1,})*$/',$_POST["bulkActionValues"]) and in_array($_POST["bulkAction"],array("aggiornaquantita")))
					{
						$bulkActionValuesArray = explode("|",$_POST["bulkActionValues"]);
						
						foreach ($bulkActionValuesArray as $bitem)
						{
							if (strcmp($bitem,"") !== 0 and strstr($bitem, ':'))
							{
								$temp = explode(":",$bitem);
								$this->$action($temp[0],$temp[1]);
							}
						}
					}
				}
			}
		}
		
		return false;
	}
	
	public function check($id, $tipo = "update")
	{
		return true;
	}
	
	public function checkRedirect($id, $tipo = "update")
	{
		if (!$this->check($id, $tipo))
		{
			$h = new HeaderObj();
			$h->redirect("panel/main");
			die();
		}
	}
	
	public function mDel($where)
	{
		$ids = $this->clear()->select($this->_idFields)->sWhere($where)->toList($this->_idFields)->send();
		
		foreach ($ids as $id)
		{
			$this->del($id);
		}
	}
	
	public function setFilters()
	{
		
	}
	
	public function update($id = null, $where = null)
	{
		if ($this->salvaRevisione)
			$old = $this->selectId($id);
		
		$result = parent::update($id, $where);
		
		if ($result && $this->salvaRevisione)
		{
			$new = $this->selectId($id);
			
			$r = new RevisioniModel();
			
			$res = $r->clear()->where(array(
				"id_tabella"	=>	(int)$id,
				"tabella"		=>	$this->_tables,
				"data_modifica"	=>	date("Y-m-d"),
			))->orderBy("id_revisione desc")->limit(1)->send(false);
			
			if ((string)json_encode($new) !== (string)json_encode($old))
			{
				if ((int)count($res) === 0 || (int)$res[0]["id_utente"] !== User::$id)
				{
					$nome = User::$data["nome"]." ".User::$data["cognome"];
					$ruolo = User::has("Admin") ? "OS" : "Cliente";
					
					$idAzienda = isset($old["id_azienda"]) ? $old["id_azienda"] : 0;
					$idAnagrafica = isset($old["id_anag"]) ? $old["id_anag"] : 0;
					
					if (!$idAzienda && $idAnagrafica && $this->_tables == "anagrafiche")
						$idAzienda = $this->idAziendaCorrente($idAnagrafica);
					
					$r->setValues(array(
						"data_modifica"	=>	date("Y-m-d"),
						"descrizione"	=>	"L'utente $nome ($ruolo) ha modificato ".$this->descrizione($id),
						"titolo"		=>	$this->titolo($id),
						"azione"		=>	"MODIFICA",
						"tabella"		=>	$this->_tables,
						"id_tabella"	=>	(int)$id,
						"id_utente"		=>	User::$id,
						"nome_utente"	=>	$nome,
						"ruolo_utente"	=>	$ruolo,
						"json"			=>	json_encode($old),
						"model"			=>	get_called_class(),
						"visibile"		=>	$this->revisioneVisibile,
						"id_azienda"	=>	$idAzienda,
						"id_anagrafica"	=>	$idAnagrafica,
						"tipo"			=>	App::$modulo,
					),"sanitizeDb");
					
					$r->insert();
				}
			}
			
			if (count($res) > 0 && (int)$res[0]["id_utente"] === User::$id)
			{
				if ((string)$res[0]["json"] === (string)json_encode($new))
				{
					$r->pDel($res[0]["id_revisione"]);
				}
			}
		}
		
		return $result;
	}
	
	public function insert()
	{
		if (App::$modulo && !User::has("Admin"))
			$this->values["id_azienda"] = User::$idAzienda;
		
		$res = parent::insert();
		
		$this->lId = $this->lastId();
		
		if ($res)
		{
			if ($this->salvaRevisione)
			{
				$r = new RevisioniModel();
				
				$nome = User::$data["nome"]." ".User::$data["cognome"];
				$ruolo = User::has("Admin") ? "OS" : "Cliente";
				
				$idAzienda = isset($this->values["id_azienda"]) ? $this->values["id_azienda"] : 0;
				$idAnagrafica = isset($this->values["id_anag"]) ? $this->values["id_anag"] : 0;
				
				if (!$idAnagrafica && $this->_tables == "anagrafiche")
					$idAnagrafica = $this->lId;
				
				if (!$idAzienda && $idAnagrafica && $this->_tables == "anagrafiche")
					$idAzienda = $this->idAziendaCorrente($idAnagrafica);
				
				$r->setValues(array(
					"data_modifica"	=>	date("Y-m-d"),
					"descrizione"	=>	"L'utente $nome ($ruolo) ha aggiunto ".$this->descrizione($this->lId),
					"titolo"		=>	$this->titolo($this->lId),
					"azione"		=>	"INSERIMENTO",
					"tabella"		=>	$this->_tables,
					"id_tabella"	=>	$this->lId,
					"id_utente"		=>	User::$id,
					"nome_utente"	=>	User::$data["nome"]." ".User::$data["cognome"],
					"ruolo_utente"	=>	$ruolo,
					"json"			=>	"",
					"model"			=>	get_called_class(),
					"visibile"		=>	$this->revisioneVisibile,
					"id_azienda"	=>	$idAzienda,
					"id_anagrafica"	=>	$idAnagrafica,
					"tipo"			=>	App::$modulo,
				),"sanitizeDb");
				
				$r->insert();
			}
		}
		
		return $res;
	}
	
	public function pUpdate($id = null, $where = null)
	{
		$res = parent::update($id, $where);
		
		return $res;
	}
	
	public function pDel($id = null, $where = null)
	{
		$res = parent::del($id, $where);
		
		return $res;
	}
	
	public function pInsert()
	{
		$res = parent::insert();
		
		$this->lId = $this->lastId();
		
		return $res;
	}
	
	public function disabilita($entries)
	{
		$entriesArray = explode(",",$entries);
		
		foreach ($entriesArray as $e)
		{
			if (isset($this->form->entry[$e]))
			{
				$this->form->entry[$e]->attributes = "disabled";
			}
		}
	}
	
	public function descrizione($id)
	{
		return $this->_tables. " " . $this->titolo($id);
	}
	
	public function titolo($id)
	{
		$clean["id"] = (int)$id;
		
		if ($clean["id"] === 0) return "";
		
		if (isset(self::$arrayTitoli[$this->_tables][$clean["id"]])) return self::$arrayTitoli[$this->_tables][$clean["id"]];
		
		$record = $this->selectId($clean["id"]);
		
		if (isset($record[$this->campoTitolo]))
		{
			self::$arrayTitoli[$this->_tables][$clean["id"]] = $record[$this->campoTitolo];
			
			return $record[$this->campoTitolo];
		}
		
		self::$arrayTitoli[$this->_tables][$clean["id"]] = "";
		return "";
	}
	
	public function gestibile($id)
	{
		return true;
	}
	
	public function attiva($id)
	{
		$clean["id"] = (int)$id;
		
		$this->values = array(
			"attivo"	=>	"Y",
		);
		
		$this->pUpdate($clean["id"]);
	}
	
	public function disattiva($id)
	{
		$clean["id"] = (int)$id;
		
		$this->values = array(
			"attivo"	=>	"N",
		);
		
		$this->pUpdate($clean["id"]);
	}
	
	//mostra il lucchetto per attivare/disattivare
	public function btnAttiva($record)
	{
		if (strcmp($record[$this->_tables]["attivo"],"No") === 0 or strcmp($record[$this->_tables]["attivo"],"N") === 0)
		{
			return '<a title="disattiva" data-bulk="attiva" class="change_trigger text text-success" href="#"><i class="fa fa-lock"></i></a>';
		}
		else
		{
			return '<a title="attiva" data-bulk="disattiva" class="change_trigger text text-success" href="#"><i class="fa fa-unlock"></i></a>';
		}
		
		return "";
	}
	
	//mostra il lucchetto per attivare/disattivare
	public function pulsanteAttiva($id)
	{
		$clean["id"] = (int)$id;
		
		$record = $this->selectId($clean["id"]);
		
		if (count($record) > 0)
		{
			if (strcmp($record["attivo"],"Y") === 0)
			{
				return '<a title="disattiva" data-bulk="disattiva" class="change_trigger text text-success" href="#"><i class="fa fa-unlock"></i></a>';
			}
			else
			{
				return '<a title="attiva" data-bulk="attiva" class="change_trigger text text-success" href="#"><i class="fa fa-lock"></i></a>';
			}
		}
		
		return "";
	}
	
	public function alias($id = null)
	{
		$clean["id"] = (int)$id;
		
		$this->values["alias"] = sanitizeDb(encodeUrl($this->values["titolo"]));
		
		if (!isset($id))
		{
			$res = $this->query("select alias from ".$this->_tables." where alias = '".$this->values["alias"]."'");
		}
		else
		{
			$res = $this->query("select alias from ".$this->_tables." where alias = '".$this->values["alias"]."' and ".$this->_idFields."!=".$clean["id"]);
		}
		
		if (count($res) > 0)
		{
			$this->values["alias"] = $this->values["alias"] . "-" . generateString(4,"123456789abcdefghilmnopqrstuvz");
		}
	}
	
	protected function upload($type = "update")
	{
		foreach ($this->uploadFields as $field => $params)
		{
			if (isset($this->values[$field]))
			{
				$this->delFields($field);
					
				if (isset($_FILES[$field]["name"]) and strcmp($_FILES[$field]["name"],'') !== 0)
				{
					$path = $params["path"];
				
					if (isset($params["allowedExtensions"]))
					{
						$this->files->setParam('allowedExtensions',$params["allowedExtensions"]);
					}
					
					if (isset($params["allowedMimeTypes"]))
					{
						$this->files->setParam('allowedMimeTypes',$params["allowedMimeTypes"]);
					}
					
					if (isset($params["maxFileSize"]))
					{
						$this->files->setParam('maxFileSize',$params["maxFileSize"]);
					}
					
					if (isset($params["createImage"]) and $params["createImage"])
					{
						$this->files->setParam('createImage',true);
					}
					
					$extArray = explode('.', $_FILES[$field]["name"]);
					$ext = strtolower(end($extArray));
					
					if ($ext === "pdf")
					{
						$this->files->setParam('createImage',false);
					}
					
					$this->files->setParam('fileUploadKey',$field);
					$this->files->setBase(ROOT."/".$path);
					
					if (isset($params["clean_field"]))
					{
						$fileName = md5(randString(22).microtime().uniqid(mt_rand(),true));
					}
					
					//crea la cartella se non c'è
					if(!is_dir(ROOT."/".$path))
					{
						if (@mkdir(ROOT."/".$path))
						{
							$fp = fopen(ROOT."/".$path.'/index.html', 'w');
							fclose($fp);
						}
					}
					
					if ($this->files->uploadFile($fileName))
					{
						$this->values[$field] = sanitizeAll($this->files->fileName);
						$this->values[$params["clean_field"]] = sanitizeAll($_FILES[$field]["name"]);
						
						if (strcmp($params["type"],"image") === 0 and isset($params["taglia"]) and isset($params["tagliaWidth"]) and isset($params["tagliaHeight"]))
						{
							$params = array(
								'imgWidth'		=>	$params["tagliaWidth"],
								'imgHeight'		=>	$params["tagliaHeight"],
								'cropImage'		=>	'yes',
								'horizAlign'	=>	'center',
								'vertAlign'		=>	'center',
								'backgroundColor' => "#FFF",
							);
							
							$thumb = new Image_Gd_Thumbnail(ROOT."/".$path,$params);
							$thumb->render($fileName.".$ext",ROOT."/".$path."/".$fileName.".$ext");
						}
						
						if (isset($params["createImage"]) && $params["createImage"] && $ext === "pdf")
						{
							$documentPath = ROOT."/".$params["path"]."/";
							
							require_once (App::$parentRoot.'/External/PDFMerger-master/PDFMerger.php');
							
							$pdf = new PDFMerger\PDFMerger;
							
							$pdf->addPDF($documentPath.$this->files->fileName, 'all');
							
							$tmpName = md5(randString(13).microtime().uniqid(mt_rand(),true)).".$ext";
							
							$this->values[$field] = sanitizeAll($tmpName);
							
							$pdf->merge('file', $documentPath.$tmpName);
							
							unlink($documentPath.$this->files->fileName);
						}
					}
					else
					{
						$this->notice = $this->files->notice;
						
						return false;
					}
				}
				else
				{
					if (isset($params["mandatory"]))
					{
						if (strcmp($type,"insert") === 0)
						{
							$vcs = new Lang_En_ValCondStrings();
							
							$this->notice = "<div class='alert'>Si prega di selezionare un file per il campo ".getFieldLabel($field)."</div>\n".$vcs->getHiddenAlertElement($field);
							
							$this->result = false;
							
							return false;
						}
					}
					else if (isset($_POST[$field."--del--"]))
					{
						$this->values[$field] = "";
						
						if (isset($params["clean_field"]))
						{
							$this->values[$params["clean_field"]] = "";
						}
					}
				}
			}
		}
		
		return true;
	}
	
	public function setUploadForms($id = 0)
	{
		$clean["id"] = (int)$id;
		
		foreach ($this->uploadFields as $field => $params)
		{
			$values = $this->selectId($clean["id"]);
			
// 			if (isset($this->values[$field]))
// 			{
				$class = (!isset($params["type"]) or strcmp(strtolower($params["type"]),"image") === 0) ? "thumb" : "file";
				
				$wrapHtml = "<div class='$class' data-field='$field' data-field-path='".$params["path"]."'>;;value;;</div>";
				
				if (isset($values[$field]) and strcmp($values[$field],"") !== 0)
				{
					$value = isset($params["clean_field"]) ? $values[$params["clean_field"]] : ";;value;;";
					
					$src = $href = Url::getRoot() . $params["path"] . "/;;value;;";
					
					if (isset($params["clean_field"]))
					{
						$src = Url::getRoot().$this->controller."/thumb/".$field."/".$clean["id"];
						$href = Url::getRoot().$this->controller."/documento/".$field."/".$clean["id"];
					}
					
					if (!isset($params["type"]) or strcmp(strtolower($params["type"]),"image") === 0)
					{
						$wrapHtml = "<div class='thumb box_immagine_upload'><a target='_blank' href='".$href."'><img src='".$src."'></a><a data-field='$field' class='text text-danger elimina_allegato' title='cancella immagine' href=''><i class='fa fa-trash'></i></a></div>";
					}
					else
					{
						
						$wrapHtml = "<div class='file box_immagine_upload'><span class='file_container'><a target='_blank' href='".$href."'>$value</a></span><a data-field='$field' class='text text-danger elimina_allegato' title='".t("Cancella documento")."' href=''><i class='fa fa-trash'></i></a></div>";
					}
				}
				
				$temp = array(
					'type'		=>	'File',
					'className'	=>	'form_file',
					'wrap'		=>	array(
						null,
						null,
						$wrapHtml,
// 						"<div class='$class' data-field='$field' data-field-path='".$params["path"]."'>;;value;;</div>",
					),
				);
					
				if (!isset($this->formStruct["entries"][$field]))
				{
					$this->formStruct["entries"][$field] = $temp;
				}
// 			}
		}
	}
	
	public function setFormStruct()
	{
		
	}
	
	public function dataOra($stringaDataOra)
	{
		$dataOra = DateTime::createFromFormat("Y-m-d H:i:s", $stringaDataOra);
		
		return $dataOra->format("d/m/Y H:i:s");
	}
	
	public function idPresente($id)
	{
		$clean["id"] = (int)$id;
		
		$record = $this->clear()->select($this->_idFields)->where(array(
			$this->_idFields => $clean["id"],
		))->record();
		
		return count($record) > 0 ? true : false;
	}
    
    public function attivaPerAzienda($record)
    {
		if (isset($record[$this->_tables]["fonte"]) && $record[$this->_tables]["fonte"] == "OS" && !User::has("Admin"))
			return "";
		
		if ($record[$this->_tables]["attiva_per_azienda"] == "No")
			return "<a class='attiva_disattiva_per_azienda' title='ELEMENTO NON ATTIVO: fai click per attivare.' href='".Url::getRoot().$this->controller."/cambiastatoelemento/Y/".$this->_tables."/".$record[$this->_tables][$this->_idFields]."'><i class='text_16 grigetto text fa fa-ban'></i></a>";
		else
			return "<a class='attiva_disattiva_per_azienda' title='ELEMENTO ATTIVO: fai click per disattivare.' href='".Url::getRoot().$this->controller."/cambiastatoelemento/N/".$this->_tables."/".$record[$this->_tables][$this->_idFields]."'><i class='text_16 verde text fa fa-check'></i></a>";
    }
	
	public function YtoS($string)
	{
		if ($string == "N" || $string == "No")
			return "No";
		
		return "Sì";
	}
	
	public function elementovisibile($record)
	{
		if ($record[$this->_tables]["elemento_visibile"] == "No" || $record[$this->_tables]["elemento_visibile"] == "N")
			return "<a class='attiva_disattiva_per_azienda' title='SEDE NON ATTIVA: fai click per attivare.' href='".Url::getRoot()."impianti/cambiastatoelemento/Y/".$this->_tables."/".$record[$this->_tables][$this->_idFields]."'><i class='text_16 grigetto text fa fa-ban'></i></a>";
		else
			return "<a class='attiva_disattiva_per_azienda' title='SEDE ATTIVA: fai click per disattivare.' href='".Url::getRoot()."impianti/cambiastatoelemento/N/".$this->_tables."/".$record[$this->_tables][$this->_idFields]."'><i class='text_16 verde text fa fa-check'></i></a>";
		
		return "";
	}
}
