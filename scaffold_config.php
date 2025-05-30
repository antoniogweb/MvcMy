<?php

Params::$language = "It";

Lang::$edit = false;

// Params::$useHttps = true;

Params::$setValuesConditionsFromDbTableStruct = true;
Params::$automaticConversionToDbFormat = true;
Params::$automaticConversionFromDbFormat = true;
Params::$automaticallySetFormDefaultValues = true;

Params::$allowedHashFunc = array('md5','sha1','sha256','passwordhash');

Params::$errorStringClassName = "text text-danger";
Params::$infoStringClassName = "alert alert-success";

Params::$allowedSanitizeFunc .= ",pulisciData,sanitizeTipoAgenda,sha256,urlPlusEncode";

Users_CheckAdmin::$usernameFieldName = 'email';
Users_CheckAdmin::$statusFieldName = 'attivo';
Users_CheckAdmin::$statusFieldActiveValue = 'Y';
Users_CheckAdmin::$idUserFieldName = 'id_utente';
Users_CheckAdmin::$idGroupFieldName = 'id_permesso';
Users_CheckAdmin::$groupsFieldName = 'titolo';

Scaffold::$autoParams["formMenu"] = "back,save,elimina";
Scaffold::$autoParams["mainMenu"] = "add";

Form_Form::$defaultEntryAttributes["className"] = "form-control";
Form_Form::$defaultEntryAttributes["submitClass"] = "btn btn-primary btn-rounded";

if (!showreport())
{
	Form_Form::$defaultEntryAttributes["formWrap"] = array(
		'',
		'',
	);
}

Helper_List::$staticShowFilters = false;
Helper_List::$staticAggregateFilters = true;

Helper_List::$tableAttributes = array('class'=>'table table-hover table-condensed table-responsive table-striped table_scaffolding','cellspacing'=>'0');

Helper_List::$actionsLayout = array(
	"edit"	=>	array(
		"text"	=>	"<i class='text_16 verde fa fa-arrow-right'></i>",
		"attributes"	=>	array(
			"class"	=>	"action_edit",
		),
	),
	"del"	=>	array(
		"attributes"	=>	array(
			"title"	=>	"elimina",
			"class"	=>	"text text-danger del_button",
		),
		"text"	=>	"<i class='fa fa-trash'></i>",
	),
);

Helper_List::$filtersFormLayout = array(
	"form"	=>	array(
		"attributes"	=>	array(
			"class"	=>	"form-inline filtri_main form_cerca",
			"role"	=>	"form",
			"autocomplete"	=>	"off",
		),
		"innerWrap"	=>	array("<span class='span_filtro_label'>Filtra per:</span>",""),
	),
	"submit" =>	array(
		"type"	=>	"button",
		"attributes"	=>	array(
			"type"	=>	"submit",
			"class"	=>	"btn btn-info",
			"style"	=>	"display:none;"
		),
		"text"	=>	"<i class='fa fa-search'></i>",
// 		"wrap"	=>	array('',"</div>"),
	),
	"clear" =>	array(
		"attributes"	=>	array(
			"type"	=>	"submit",
			"class"	=>	"btn btn-primary",
		),
// 				"text"	=>	"pulisci",
	),
	"filters"	=>	array(
		"cerca"		=>	array(
			"type"	=>	"input",
			"attributes"	=>	array(
				"class"	=>	"form-control",
				"placeholder"	=>	"cerca",
				"style"	=>	"display:none;"
			),
// 			"wrap"	=>	array('<div class="form-group pull-right">',""),
		),
		"attivo"		=>	array(
			"type"	=>	"select",
			"attributes"	=>	array(
				"class"	=>	"form-control",
			),
		),
		"id_permesso"	=>	array(
			"type"	=>	"select",
			"attributes"	=>	array(
				"class"	=>	"form-control",
			),
		),
		"dal"		=>	array(
			"type"	=>	"input",
			"attributes"	=>	array(
				"class"	=>	"form-control data_filtro",
				"placeholder"	=>	"dal",
// 				"data-mask"	=>	"99/99/9999",
			),
			"wrap"	=>	array(
				'<div class="input-group date">','<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>'
			),
		),
		"al"		=>	array(
			"type"	=>	"input",
			"attributes"	=>	array(
				"class"	=>	"form-control data_filtro",
				"placeholder"	=>	"al",
// 				"data-mask"	=>	"99/99/9999",
			),
			"wrap"	=>	array(
				'<div class="input-group date">','<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>'
			),
		),
		"dal_al"		=>	array(
			"type"	=>	"input",
			"attributes"	=>	array(
				"class"	=>	"form-control",
				"placeholder"	=>	"dal - al",
				"id"		=>	"filtro_daterange",
			),
			"wrap"	=>	array(
				'<div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>','</div>'
			),
		),
	),
);

$tempFilters = array();

foreach (Helper_List::$filtersFormLayout["filters"] as $key => $filter)
{
	$filter["attributes"]["autocomplete"] = "off";
	
	$tempFilters[$key] = $filter;
}

Helper_List::$filtersFormLayout["filters"] = $tempFilters;

Helper_Pages::$pageLinkWrap = array("li");

Helper_Pages::$staticCurrentClass = "active disabled";

Helper_Pages::$staticShowFirstLast = true;

Helper_Pages::$staticFirstLastDividerHtml = "<li class='active disabled'><a href=''>...</a></li>";

Helper_Menu::$htmlLinks = array(
	"back" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-primary pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<span class="glyphicon glyphicon-circle-arrow-left"></span> '."Elenco",
	),
	"add" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-primary pull-right btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<i class="fa fa-plus-square-o"></i> '."Aggiungi",
	),
	"disattiva" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-warning pull-right btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	"<i class='fa fa-lock'></i> Disattiva",
		'queryString'	=>	'&disattiva=Y',
	),
	"attiva" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-info pull-right btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	"<i class='fa fa-unlock'></i> Attiva",
		'queryString'	=>	'&attiva=Y',
	),
	"esporta" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-info pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="glyphicon glyphicon-download-alt"></span> '."Esporta",
		'url'	=>	'main',
		'queryString'	=>	'&esporta=Y',
	),
	"scarica" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-danger pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="fa fa-file-pdf-o"></span> '."Scarica",
		'url'	=>	'main',
		'queryString'	=>	'&scarica=Y',
	),
	"stampa" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-info pull-right stampa_pagina btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="glyphicon glyphicon-download-alt"></span> '."Stampa",
		'url'	=>	'main',
// 				'queryString'	=>	'&esporta=Y',
	),
	"stampa_app" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'target="_blank" role="button" class="btn btn-info pull-right btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="glyphicon glyphicon-download-alt"></span> '."Stampa",
		'url'	=>	'main',
		'controller'	=>	'clienti',
// 				'queryString'	=>	'&esporta=Y',
	),
	"pdf" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'target="_blank" role="button" class="btn btn-info pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="glyphicon glyphicon-download-alt"></span> '."Pdf",
		'url'	=>	'form/update',
		'queryString'	=>	'&pdf=Y&skip=Y',
	),
	"pdf_cartella" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'target="_blank" role="button" class="btn btn-info pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-info",
		'text'	=>	'<span class="glyphicon glyphicon-download-alt"></span> '."Pdf",
		'url'	=>	'cartellaclinica',
		'queryString'	=>	'&pdf=Y&skip=Y',
	),
	"copia" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-info pull-right btn-outline btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<span class="glyphicon glyphicon-repeat"></span> '."Duplica",
		'url'	=>	'form/update',
		'queryString'	=>	'&duplica=Y',
	),
	"report" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-default pull-right margin-left-button iframe btn-outline btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<span class="glyphicon glyphicon-font"></span> '."Report",
		'url'	=>	'form/update',
		'queryString'	=>	'&report=Y&skip=Y&partial=Y&nobuttons=N',
	),
	"report_full" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'target="_blank" role="button" class="btn btn-default pull-right margin-left-button btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<span class="glyphicon glyphicon-resize-full"></span> '."Schermo intero",
		'url'	=>	'form/update',
		'queryString'	=>	'&report=Y&skip=Y&partial=Y&nobuttons=Y',
	),
	"modifica" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-success btn-rounded "',
		"class"	=>	"btn btn-success",
		'text'	=>	'<span class="glyphicon glyphicon-edit"></span> '."Modifica",
		'url'	=>	'form/update',
		'queryString'	=>	'&report=N&buttons=Y',
	),
	"edit" => array(
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-primary btn-rounded "',
		"class"	=>	"btn btn-default",
		'text'	=>	'<span class="glyphicon glyphicon-edit"></span> '."Modifica",
	),
	'save'	=>	array(
		'title'	=>	"salva",
		'text'	=>	'<i class="fa fa-check-square-o"></i> '."Salva",
		'url'	=>	'main',
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-primary save_button menu_btn pull-right btn-rounded "',
	),
	'elimina'	=>	array(
		'title'	=>	"elimina",
		'text'	=>	'<span class="glyphicon glyphicon-remove"></span> '."Elimina",
		'url'	=>	'main',
		"htmlBefore" => '',
		"htmlAfter" => '',
		"attributes" => 'role="button" class="btn btn-danger elimina_button pull-right btn-rounded "',
	),
);

// Form_Entry::$defaultEntryClass = "form-group";
// Form_Entry::$defaultLabelClass = "col-sm-2 control-label";
Form_Entry::$defaultWrap = array(
	'',
	'',
	'',
	'',
// 	'<div class="hr-line-dashed"></div>',
);

// // Form_Entry::$defaultEntryClass = "form-group";
// // Form_Entry::$defaultLabelClass = "col-sm-2 control-label";
// Form_Entry::$defaultWrap = array(
// 	'',
// 	'',
// 	'<div class="input-group">
// 		<span class="input-group-addon">
// 				<i class="fa fa-pencil-square-o"></i>
// 		</span>	',
// 	'</div>',
// // 	'<div class="hr-line-dashed"></div>',
// );

require_once(ROOT."/External/mobile_detect.php");
$detect = new Mobile_Detect();
$is_mobile = $detect->isMobile();
User::$mobile = (isset($is_mobile) && $is_mobile) ? true : false;
$is_tablet = $detect->isTablet();
User::$tablet = (isset($is_tablet) && $is_tablet) ? true : false;
User::$phone = ($detect->isMobile() && !$detect->isTablet()) ? 1 : 0;

