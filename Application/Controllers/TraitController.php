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

trait TraitController
{
	protected $_posizioni = array();
	
	protected $_topMenuClasses = array();
	
// 	public $id_manutenzione = null;
	
// 	public $ricreaCompl = false;
	
	public $id = 0;
	
	public $shift = 0;
	
	public $id_name = "";
	
	public $parentRoot = null;
	
	public $formAction = null;
	
	public $formView = "form";
	
	public $mainView = "main";
	
	public $associatiView = null;
	
	public $formFields = null;
	
	public $disabledFields = null;
	
	public $menuLinksStruct = array();
	
	public $menuLinks = "save,back";
	
	public $menuLinksReport = "stampa";
	
	public $menuLinksInsert = "save,back";
	
	public $insertSubmitText = "Continua";
	
	public $updateRedirect = true;
	
	public $updateRedirectUrl = null;
	
	public $insertRedirect = true;
	
	public $insertRedirectUrl = null;
	
	public $formMethod = null;
	
	public $mainButtons = 'ldel,ledit';
	
	public $mainFields = array();
	
	public $mainCsvFields = null;
	
	public $mainHead = "";
	
	public $mainCsvHead = null;
	
	public $addBulkActions = true;
	
	public $bulkActions = null;
	
	public $setAttivaDisattivaBulkActions = true;
	
	public $queryActions = "del";
	
	public $queryFormActions = "insert,update";
	
	public $queryActionsAfter = "";
	
	public $bulkQueryActions = "del";
	
	public $nullQueryValue = "tutti";
	
	public $tabella = null;
	
	public $tabellaSingolare = null;
	
	public $scaffoldParams = array('recordPerPage'=>50, 'mainMenu'=>'esporta,add');
	
	public $colProperties = array(
			array(
				'width'	=>	'20px',
			),
		);
	
	public $orderBy = "";
	
	public $filters = array();
	
	public $sezionePannello = "gestionale";
	
	public $useEditor = false;
	
	public $formDefaultValues = array();
	
	public $wrapTable = true;
	
	public $wrapTBody = true;
	
	public $wbsi = null;
	
	public $aggregateFilters = true;
	
	public $showFilters = false;
	
	public $filtroAttivo = array("tutti"=>"Attivi / NON Attivi","Y"=>"Attivi","N"=>"NON Attivi");
	
	public static $filtroPagato = array("tutti"=>"Pagato / NON pagato","Y"=>"Pagato","N"=>"NON pagato");
	
	public $filtroDaFare = array("tutti"=>"-- Mostra tutti --","Y"=>"Da fare");
	
	public $filtroConclusa = array("tutti"=>"Tutti","N" => "No","Y" => "Sì");
	public $filtroConclusaEseguita = array("tutti"=>"Tutti","N" => "Non eseguito","Y" => "Eseguito");
	
	public $csvColumnsSeparator = ",";
	
	public $functionUponCsvCellValue = "htmlentitydecode";
	
	protected function generaPosizioni()
	{
		$metodi = get_class_methods($this);
		
		foreach ($metodi as $m)
		{
			$this->_posizioni[$m] = null;
		}
	}
	
	protected function thumb($field = "", $id = 0)
	{
		$this->clean();
		
		$clean["id"] = (int)$id;
		
		if (isset($this->m[$this->modelName]->uploadFields[$field]))
		{
			$params = $this->m[$this->modelName]->uploadFields[$field];
			$path = $params["path"];
			$folder = ROOT."/".trim($path,"/");
			
			$record = $this->m[$this->modelName]->selectId($clean["id"]);
			
			if (strcmp($record[$field],"") !== 0 and file_exists($folder."/".$record[$field]))
			{
				$p = array(
					'imgWidth'		=>	400,
					'imgHeight'		=>	400,
					'defaultImage'	=>  null,
					'cropImage'		=>	'no',
				);
				
				if (isset($params["thumb"])) $p = $params["thumb"];
				
				$thumb = new Image_Gd_Thumbnail($folder,$p);
				$thumb->render($record[$field]);
			}
		}
	}
	
	protected function thumblista($field = "", $id = 0)
	{
		$this->clean();
		
		$clean["id"] = (int)$id;
		
		if (isset($this->m[$this->modelName]->uploadFields[$field]))
		{
			$params = $this->m[$this->modelName]->uploadFields[$field];
			$path = $params["path"];
			$folder = ROOT."/".trim($path,"/");
			
			$record = $this->m[$this->modelName]->selectId($clean["id"]);
			
			if (strcmp($record[$field],"") !== 0 and file_exists($folder."/".$record[$field]))
			{
				$p = array(
					'imgWidth'		=>	80,
					'imgHeight'		=>	80,
					'defaultImage'	=>  null,
					'cropImage'		=>	'no',
				);
				
// 				if (isset($params["thumb"])) $p = $params["thumb"];
				
				$thumb = new Image_Gd_Thumbnail($folder,$p);
				$thumb->render($record[$field]);
			}
		}
	}
	
	protected function documento($field = "", $id = 0)
	{
		$this->clean();
		
		$clean["id"] = (int)$id;
		
		if (isset($this->m[$this->modelName]->uploadFields[$field]))
		{
			$params = $this->m[$this->modelName]->uploadFields[$field];
			$path = $params["path"];
			$folder = ROOT."/".trim($path,"/");
			
			$record = $this->m[$this->modelName]->selectId($clean["id"]);
			
			if (strcmp($record[$field],"") !== 0 and file_exists($folder."/".$record[$field]))
			{
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$MIMEtype = finfo_file($finfo, $folder."/".$record[$field]);
				finfo_close($finfo);
				
				$fileName = isset($params["clean_field"]) ? $record[$params["clean_field"]] : $record[$field];
				
				$cd = isset($params["Content-Disposition"]) ? $params["Content-Disposition"] : "attachment";
				
				header('Content-type: '.$MIMEtype);
				header('Content-Disposition: '.$cd.'; filename='.$fileName);
				readfile($folder."/".$record[$field]);
			}
		}
	}
	
	protected function main()
	{
		$this->s['admin']->check();
		
		$this->shift($this->shift);
		
		$this->m[$this->modelName]->viewStatus = $this->viewStatus;
		
		if ($this->id !== 0)
		{
			$clean['id'] = $data['id'] = (int)$this->id;
			$this->mainView = isset($this->associatiView) ? $this->associatiView : "associati";
		}
		
		$data['topCercaName'] = "cerca";
		$data["f_data_dal"] = "f_data_dal";
		$data["f_data_al"] = "f_data_al";
		
		$data['posizioni'] = $this->_posizioni;
		$data['tm'] = $this->_topMenuClasses;
		
		Params::$nullQueryValue = $this->nullQueryValue;
		
		$primaryKey = $this->m[$this->modelName]->getPrimaryKey();
		$table = $this->m[$this->modelName]->table();
		
		$data["tabella"] = isset($this->tabella) ? $this->tabella : $table;
		
		$data['type'] = $data['queryType'] = "main";
		
		$data["title"] = $titleReport = "Gestione " . $data["tabella"];
		
		$this->m[$this->modelName]->updateTable($this->queryActions);
		
// 		print_r($this->m[$this->modelName]->backupSelect);
		
		if ($this->addBulkActions)
		{
			if (!isset($this->bulkActions) or !is_array($this->bulkActions))
			{
				$bulkQueryActions = "del";
				
				if ($this->setAttivaDisattivaBulkActions)
				{
					$bulkQueryActions .= ",attiva,disattiva";
				}
				
				if ($this->m[$this->modelName]->bulkAction($bulkQueryActions))
				{
					if ($this->id)
						$this->redirect($this->controller."/".$this->action."/".$this->id.$this->viewStatus);
					else
						$this->redirect($this->controller."/".$this->action.$this->viewStatus);
				}
			}
			else
			{
				if ($this->m[$this->modelName]->bulkAction($this->bulkQueryActions))
				{
					if ($this->id)
						$this->redirect($this->controller."/".$this->action."/".$this->id.$this->viewStatus);
					else
						$this->redirect($this->controller."/".$this->action.$this->viewStatus);
				}
			}
		}
		
// 		$temp = $this->m[$this->modelName]->backupSelect;
		
// 		if (isset($this->id_manutenzione))
// 		{
// 			$this->m["ScadenzeModel"]->ricrea((int)$this->id_manutenzione);
// 		}
// 		
// 		if ($this->ricreaCompl)
// 		{
// 			$this->m["ScadenzeModel"]->ricreaCompleto();
// 		}
		
// 		$this->m[$this->modelName]->backupSelect = $temp;
		
// 		print_r($this->m[$this->modelName]->backupSelect);
		
		$this->m[$this->modelName]->setFilters();
		
		$this->loadScaffold('main',$this->scaffoldParams);
		
		$mainFields = $this->mainFields;
		$mainHead = $this->mainHead;
		
		if ($this->addBulkActions)
		{
			$mainFields = array_merge(array("[[checkbox]];$table.$primaryKey;"),$this->mainFields);
			$mainHead = "[[bulkselect:checkbox_".$table."_".$primaryKey."]],".$this->mainHead;
		}
		
		if (isset($_GET["esporta"]))
		{
			$this->mainButtons = "";
			$this->addBulkActions = false;
			
			if (isset($this->mainCsvFields) and isset($this->mainCsvHead))
			{
				$mainFields = $this->mainCsvFields;
				$mainHead = $this->mainCsvHead;
			}
		}
		
		$this->scaffold->loadMain($mainFields,$table.'.'.$primaryKey,$this->mainButtons);
		
		$this->scaffold->setHead($mainHead);
		
		$this->scaffold->itemList->wrapTable = $this->wrapTable;
		$this->scaffold->itemList->wrapTBody = $this->wrapTBody;
		
		if ($this->addBulkActions)
		{
			if (!isset($this->bulkActions) or !is_array($this->bulkActions))
			{
				$bulkActions =  array(
					"checkbox_".$table."_".$primaryKey	=>	array("del","Elimina selezionati","confirm"),
				);
				
				if ($this->setAttivaDisattivaBulkActions)
				{
					$bulkActions[" checkbox_".$table."_".$primaryKey] = array("attiva","Attiva selezionati");
					$bulkActions["  checkbox_".$table."_".$primaryKey] = array("disattiva","Disattiva selezionati");
				}
				
				$this->scaffold->itemList->setBulkActions($bulkActions);
			}
			else
			{
				$this->scaffold->itemList->setBulkActions($this->bulkActions);
			}
		}
		
		$formAction = isset($this->formMethod) ? $this->formMethod : "form";
		
// 		$this->scaffold->mainMenu->links['esporta']['url'] = "main";
		
		$this->scaffold->mainMenu->links['add']['url'] = $formAction.'/insert/0';
		$this->scaffold->mainMenu->links['add']['title'] = 'inserisci un nuovo elemento';
		
		if (isset($this->scaffold->mainMenu->links['elimina']) and $this->id !== 0)
		{
			$this->scaffold->mainMenu->links['elimina']['attributes'] = 'role="button" class="pull-right btn btn-danger elimina_button menu_btn" rel="'.$this->id_name.'" id="'.$clean['id'].'"';
		}
		
		if (isset($this->scaffold->mainMenu->links['pdf']) and $this->id !== 0)
		{
			$this->scaffold->mainMenu->links['pdf']['url'] = 'cartellaclinica/'.$this->id;
		}
		
		if ($this->controller == "righe" && ($this->action == "esporta" || $this->action == "esportaofferte"))
		{
			$this->scaffold->mainMenu->links['esporta']['url'] = $this->action;
		}
		
		$this->scaffold->model->clear()->restore();
		
// 		print_r($this->scaffold->model);
		
		$this->m[$this->modelName]->updateTable($this->queryActionsAfter);
		
		$this->scaffold->fields = $this->scaffold->model->select;
		
		$this->scaffold->itemList->colProperties = $this->colProperties;
		
		$this->scaffold->itemList->setFilters($this->filters);
		
		$this->scaffold->itemList->csvColumnsSeparator = $this->csvColumnsSeparator;
		
		$this->scaffold->itemList->functionUponCsvCellValue = $this->functionUponCsvCellValue;
		
// 		if ($this->aggregateFilters)
// 		{
// 			$this->scaffold->itemList->aggregateFilters();
// 		}
// 		
// 		if (!$this->showFilters)
// 		{
// 			$this->scaffold->itemList->showFilters = false;
// 		}
		
		if (isset($_GET["esporta"]))
		{
// 			$this->scaffold->itemList->renderToCsv = true;
			
			$this->scaffold->params["recordPerPage"] = 10000000000;
			$this->scaffold->params['pageList'] = false;
			
			$data['scaffold'] = $this->scaffold->render();
			
			$data['main'] = $this->scaffold->html['main'];
			
			$this->clean();
			
			header('Content-disposition: attachment; filename='.date("Y-m-d_H_i_s")."_esportazione_".encodeUrl($data["tabella"]).".xls");
			header('Content-Type: application/vnd.ms-excel');
			
			// header('Content-Disposition: attachment; filename=Customers_Export.csv');
			echo "\xEF\xBB\xBF"; // UTF-8 BOM
			echo $data['main'];
		}
		else
		{
			$data['scaffold'] = $this->scaffold->render();
			
			$data['numeroElementi'] = $this->scaffold->model->rowNumber();
			
			$data['menu'] = $this->scaffold->html['menu'];
// 			$data['popup'] = $this->scaffold->html['popup'];
			$data['main'] = $this->scaffold->html['main'];
			$data['pageList'] = $this->scaffold->html['pageList'];
			$data['notice'] = $this->scaffold->model->notice;
			
			$data['recordPerPage'] = $this->scaffold->params["recordPerPage"];
			$data["filtri"] = $this->scaffold->itemList->createFilters();
			
			$this->load($this->mainView);
		}
		
		$this->append($data);
		
	}
	
	protected function form($queryType = 'insert', $id = 0)
	{
		$this->shift(2);
		
// 		$this->s['admin']->check();
		
		if (isset($_GET["pdf"]))
		{
			$_GET["report"] = "Y";
			$_GET["partial"] = "Y";
			$_GET["buttons"] = "N";
		}
		
		$data['posizioni'] = $this->_posizioni;
		$data['tm'] = $this->_topMenuClasses;
		
		$qAllowed = array("insert","update");
		
		$data["useEditor"] = $this->useEditor;
		
		if (in_array($queryType,$qAllowed))
		{
			$clean["id"] = $data["id"] = (int)$id;
			
			if (strcmp($queryType,"update") === 0)
				$checkAccesso = $this->m[$this->modelName]->check($id, "update"); 
			else
				$checkAccesso = $this->m[$this->modelName]->check($id, "insert"); 
			
			if (!$checkAccesso)
			{
				$this->redirect("panel/main");
				die();
			}
			
			$table = $this->m[$this->modelName]->table();
			
			$data["tabella"] = isset($this->tabella) ? $this->tabella : $table;
			
			if (isset($this->tabellaSingolare))
			{
				$data["tabella"] = $this->tabellaSingolare;
			}
			
			$data["queryType"] = $data["type"] = $queryType;
			
			if (!showreport() and !isset($_GET["pdf"]))
			{
				$this->m[$this->modelName]->updateTable($this->queryFormActions,$clean["id"]);
			}
			
			$data["queryResult"] = $this->m[$this->modelName]->queryResult;
			
			if (isset($_POST["gAction"]))
			{
				$this->m[$this->modelName]->result = false;
			}
			
			$nomeElemento = "elemento";
			
			if (isset($this->tabellaSingolare))
			{
				$nomeElemento = $this->tabellaSingolare;
			}
			
			$data["titoloRecord"] = "Inserimento $nomeElemento";
			
			if (strcmp($queryType,'update') === 0)
			{
				$data["titoloRecord"] = $this->m[$this->modelName]->titolo($clean["id"]);
			}
			
			if (strcmp($queryType,'insert') === 0)
			{
				$this->menuLinks = $this->menuLinksInsert;
			}
			
			$queryStringChar = Params::$rewriteStatusVariables ? "?" : "&";
			
			$partial = isset($_GET["partial"]) ? $queryStringChar."partial=Y" : null;
			$partialU = isset($_GET["partial"]) ? $queryStringChar."partial=Y&" : $queryStringChar;
			
			if (isset($this->viewArgs["partial"]))
			{
				$partial = null;
				$partialU = $queryStringChar;
			}
			
			$formAction = isset($this->formAction) ? $this->formAction : $this->controller."/".$this->action."/$queryType/".$clean["id"].$partial;
			
			if (strcmp($queryType,'insert') === 0 and $this->m[$this->modelName]->queryResult and $this->insertRedirect)
			{
				$lId = $this->m[$this->modelName]->lId;
				
				flash("notice",$this->m[$this->modelName]->notice);
				
				if (isset($this->insertRedirectUrl))
				{
					$this->redirect($this->insertRedirectUrl);
				}
				else
				{
					$this->redirect($this->controller.'/form/update/'.$lId.$this->viewStatus.$partialU);
				}
			}
			
			if (strcmp($queryType,'update') === 0 and $this->m[$this->modelName]->queryResult and $this->updateRedirect)
			{
				if (!isset($_POST["nodesc"]))
					flash("notice",$this->m[$this->modelName]->notice);
				
				if (isset($this->updateRedirectUrl))
					$this->redirect($this->updateRedirectUrl.$this->viewStatus);
				else
					$this->redirect($this->controller.'/form/update/'.$clean["id"].$this->viewStatus);
			}
			
			if (strcmp($queryType,'update') === 0 and $this->m[$this->modelName]->queryResult and isset($_POST["redirectToList"]))
			{
				flash("notice",$this->m[$this->modelName]->notice);
				
				$this->redirect($this->controller.'/main/'.$this->viewStatus);
			}
			
			$this->m[$this->modelName]->setFormStruct();
			
			$this->m[$this->modelName]->setUploadForms($clean["id"]);
			
			if (strcmp($queryType,'update') === 0 and showreport() && $this->controller != "revisioni")
			{
				$this->menuLinks = $this->menuLinksReport;
			}
			
			$params = array(
				'formMenu'=>$this->menuLinks,
			);
			
			$this->loadScaffold('form',$params);
			$this->scaffold->loadForm($queryType,$formAction);
			$this->scaffold->form->className = "main_form";
			
			if (isset($this->scaffold->mainMenu->links['pdf']))
			{
				$this->scaffold->mainMenu->links['pdf']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['disattiva']))
			{
				$this->scaffold->mainMenu->links['disattiva']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['attiva']))
			{
				$this->scaffold->mainMenu->links['attiva']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['copia']))
			{
				$this->scaffold->mainMenu->links['copia']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['report']))
			{
				$this->scaffold->mainMenu->links['report']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['modifica']))
			{
				$this->scaffold->mainMenu->links['modifica']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['report_full']))
			{
				$this->scaffold->mainMenu->links['report_full']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($this->scaffold->mainMenu->links['refresh']))
			{
				$this->scaffold->mainMenu->links['refresh']['url'] = 'form/update/'.$clean["id"];
			}
			
			if (isset($_GET["insert"]))
			{
				$this->scaffold->model->notice = "<div class='alert alert-success'>operazione eseguita!</div>\n";
				$data["queryResult"] = true;
			}
			
			if (isset($this->disabledFields))
			{
				$this->scaffold->model->disabilita($this->disabledFields);
			}
			
			$this->scaffold->model->fields = isset($this->formFields) ? $this->formFields : $this->scaffold->model->fields;
			
			$this->scaffold->getFormValues('sanitizeHtml',$clean["id"],$this->formDefaultValues);
			
			if (count($this->menuLinksStruct) > 0)
			{
				foreach ($this->menuLinksStruct as $k => $v)
				{
					$this->scaffold->mainMenu->links[$k] = $v;
				}
			}
			
			if (showreport())
			{
				$this->scaffold->form->setReport(skipIfEmpty());
			}
			
			if (isset($_GET["pdf"]) or showreport())
			{
				foreach ($this->scaffold->values as $key => $value)
				{
					$this->scaffold->values[$key] = nl2br(strip_tags(br2nl(htmlentitydecode($this->scaffold->values[$key]))));
					
					if (isset($this->scaffold->model->uploadFields[$key]))
					{
						$params = $this->scaffold->model->uploadFields[$key];
						
						if (strcmp($this->scaffold->values[$key],"") !== 0 and file_exists(ROOT."/".trim($params["path"],"/")."/".$this->scaffold->values[$key]))
						{
							if (strcmp($params["type"],"image") === 0)
							{
								if (!isset($_GET["pdf"]))
								{
									$src = Domain::$name."/".$params["path"]."/".$value;
								}
								else
								{
									$src = ROOT."/".$params["path"]."/".$value;
								}
								
								if (isset($params["clean_field"]) and !isset($_GET["pdf"]))
								{
									$src = Url::getRoot().$this->controller."/thumb/".$key."/".$clean["id"];
								}
								
								$style = isset($_GET["pdf"]) ? "style='width:300px'" : null;
								
								$this->scaffold->values[$key] = "<img $style src='".$src."' />";
							}
							else if (strcmp($params["type"],"file") === 0)
							{
								$linkText = $value;
								
								if (isset($params["clean_field"]))
								{
									$record = $this->m[$this->modelName]->selectId($clean["id"]);
									
									if (isset($record[$params["clean_field"]]))
									{
										$linkText = $record[$params["clean_field"]];
									}
								}
								
								$href = Domain::$name."/".$params["path"]."/".$value;
								
								if (isset($params["clean_field"]))
								{
									$href = Url::getRoot().$this->controller."/documento/".$key."/".$clean["id"];
								}
								
								$this->scaffold->values[$key] = "<a href='".$href."'>$linkText</a>";
							}
						}
					}
				}
			}
			
			$data["form"] = array();
			
			foreach ($this->scaffold->values as $key => $value)
			{
				$data["form"][$key] = $this->scaffold->model->form->entry[$key]->render($value);
			}
			
			$data['scaffold'] = $this->scaffold->render();
			
			$data['menu'] = $this->scaffold->html['menu'];
			$data['main'] = $mainContent = $this->scaffold->html['main'];
			$data['notice'] = $this->scaffold->model->notice;
			
			$stringaTitolo = (!showreport()) ? "Gestione" : "Visualizzazione";
			$data["title"] = $stringaTitolo . " " . $data["tabella"] . ": " . $data["titoloRecord"];
			$titleReport = $data["titoloRecord"];
			
			if (!isset($_GET["pdf"]))
			{
				$this->append($data);
				$this->load($this->formView);
			}
			else
			{
				
			}
		}
	}
	
	public function ordina()
	{
		$this->s['admin']->check();
		
		$this->clean();
		
		if (strstr($this->orderBy, "ordine"))
		{
			if (isset($_POST["ordinaPagine"]))
			{
				$clean["order"] = $this->request->post("order","","sanitizeAll");
				
				$orderArray = explode(",",$clean["order"]);
				
				$orderClean = array();
				
				foreach ($orderArray as $id_table)
				{
					if ((int)$id_table !== 0)
					{
						$orderClean[] = (int)$id_table;
					}
				}
				
// 				$where = "in(".implode(",",$orderClean).")";
				
				$idOrderArray = $this->m[$this->modelName]->where(array(
					"in" => array($this->m[$this->modelName]->getPrimaryKey() => $orderClean),
				))->toList("ordine")->send();
				
// 				if ($this->orderBy === "pages.id_order")
				if (!strstr(strtolower($this->orderBy), "desc"))
				{
					sort($idOrderArray);
				}
				else
				{
					rsort($idOrderArray);
				}
				
				for ($i=0; $i<count($orderClean); $i++)
				{
					if (isset($idOrderArray[$i]))
					{
						$this->m[$this->modelName]->values = array(
							"ordine" => (int)$idOrderArray[$i],
						);
						$this->m[$this->modelName]->pUpdate((int)$orderClean[$i]);
					}
				}
				
// 				print_r($this->m[$this->modelName]->db->queries);
			}
		}
	}
}
