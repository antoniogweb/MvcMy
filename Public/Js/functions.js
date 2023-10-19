<!--

var tiny_editor_config = {
	// Location of TinyMCE script
	script_url :  baseUrl+ '/Public/Js/tiny_mce/tiny_mce.js',
	convert_urls : false,

	force_br_newlines : true,
	force_p_newlines : false,
	forced_root_block : '',
	entity_encoding : "raw",
// 			width : "910",
// 			height : "700",
	
	// General options
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

	// Theme options
	theme_advanced_buttons1 : "forecolor,backcolor,bold,italic,underline,strikethrough,bullist,numlist,justifyleft,justifycenter,justifyright,justifyfull,sub,sup,charmap,code",
	theme_advanced_buttons2 : "link,unlink,anchor,formatselect,fontselect,fontsizeselect",
	
	theme_advanced_font_sizes : '10px,11px,12px,14px,15px,16px,18px,24px,30px,36px,48px,60px,72px',
	
// 	file_browser_callback : "ajaxfilemanager",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	accessibility_warnings : false,
	accessibility_focus : false
};

jQuery(function($){
	$.datepicker.regional['it'] = {
		closeText: 'Chiudi',
		prevText: '&#x3c;Prec',
		nextText: 'Succ&#x3e;',
		currentText: 'Oggi',
		monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
		monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
		dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['it']);
});

var closedd = false;

var child;
var timer;
var changed = false;

function checkChild() {
    if (child.closed || closedd) {
        clearInterval(timer);
		
		reloadPage();
		
// 		location.reload();
    }
}

function reloadPage()
{
	if ($(".obiettivosviluppo_form").length > 0)
	{
		if (changed)
		{
			$(".obiettivosviluppo_form").find(".submit_entry button").attr("name","gAction");
			$(".obiettivosviluppo_form").find(".submit_entry input").attr("name","gAction");
			$(".obiettivosviluppo_form").submit();
		}
		else
			location.reload();
	}
	else
	{
		location.reload();
// 		window.location=window.location;
	}
}

$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-square-o').removeClass('fa-minus-square-o');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-square-o').removeClass('fa-plus-square-o');
        }
        e.stopPropagation();
    });
});

function aggiornaAltezzaIframe()
{
// 	console.log(window.parent);
	if (partial && window.frameElement)
	{
		setTimeout(function(){
				if (actionName != "file")
					var aa = $("#page-wrapper_partial").height()+20;
				else
					var aa = $(window.parent).height()-220;
				
				window.parent.$("iframe.dialog_iframe").attr("height",aa + "px");
				window.parent.$('#my_modal').modal({refresh:true});
		}, 10);
	}
}

$(document).ready(function(){
	
	$('.main_form').on('change paste', ':input', function(e) {
		changed = true;
	});
	
	$('.main_form').on('change', 'select', function(e) {
		changed = true;
	});
	
	$(".print_page").click(function(e){
		
		e.preventDefault();
		
		$("#page-wrapper").addClass("print");
		
		window.print();
		
	});
	
	$("td.delForm form,.del_row,td.ldel a,.view_del_link").click(function () {

		if (window.confirm("vuoi veramente cancellare la riga?")) {
			return true;
		}

		return false;
	});

	$(".first_level_item").mouseover(function(){
		$(this).find("ul").first().css("display","block");
	}).mouseout(function(){
		$(this).find("ul").css("display","none");
	});

	$(".second_level_item").mouseover(function(){
		$(this).find("ul").css("display","block");
	}).mouseout(function(){
		$(this).find("ul").css("display","none");
	});
	
	$(".stampa_pagina").click(function(){
		
		window.print();
		
		return false;
	});
	
	if ($(".mainMenu").length > 0)
	{
		var top_menu = '<br />' + $(".mainMenu").html();
		$(".main").append(top_menu);
	}
	
	$(".save_button").click(function(e){
		
		e.preventDefault();
		
		$(".submit_entry").find("button").trigger('click');
	});
	
	$(".resetta_button").click(function(e){
		
		e.preventDefault();
		
		window.location.href=window.location.href;
		
	});

	$(".elimina_button").click(function(e){
	
		var that = $(this);
		
		e.preventDefault();
		
		if (window.confirm("Vuoi veramente cancellare l'elemento?")) {
		
			if ($(".formClass").find("input[type='hidden']").length > 0)
			{
				var id = $(".formClass").find("input[type='hidden']").val();
				var t_name = $(".formClass").find("input[type='hidden']").attr("name");
			}
			else
			{
				var id = that.attr("id");
				var t_name = that.attr("rel");
			}
			
			if (id != 0)
			{
				var formHtml = '<form class="hidden_form" method="POST" action="'+baseUrl+'/'+controllerName+'/main'+viewStatus+'"><input type="hidden" value="cancella" name="delAction"><input type="hidden" value="'+id+'" name="'+t_name+'"></form>';
				
				$("body").append(formHtml);
				
				$(".hidden_form").submit();
			}
		}
	});
	
	$("body").on("click", ".iframe_td a, a.iframe", function(e){
		
		var t_href = $(this).attr("href");
		
		var refresh = true;
		var that = $(this);
		
		if ($(this).hasClass("no-refresh"))
			refresh = false;
// 		console.log(t_href);
		
		e.preventDefault();
		
		$('.modal').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
			$(this).find('iframe').attr('src',t_href)
		});
		
		$('.modal').on('hide.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
			if (refresh)
			{
				var attr = that.attr('applica_funzione');
				
				if (typeof attr !== typeof undefined && attr !== false)
					window[attr]();
				else
					reloadPage();
			}
			
			$(this).off('hide.bs.modal');
		});
		
		$('#my_modal').modal({show:true});
	});

	$("body").on("click", ".edit_traduzione", function(e){
		
		e.preventDefault();
		
		var id_t = $(this).attr("data-id");
		
		var t_href = baseUrl + "/traduzioni/form/update/" + id_t + "?partial=Y&nobuttons=Y";
		
		$('.modal').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
			$(this).find('iframe').attr('src',t_href)
		});
		
		$('.modal').on('hide.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
			reloadPage();
		});
		
		$('#my_modal').modal({show:true});
	});
	
	if ($(".formClass").length > 0)
	{
		$(".formClass input, .formClass select, .formClass textarea").change(function(){
			
			form_modificato = true;
			
		});
		
		$(".nav_dettaglio a, .nav-sidebar a, .panel-title a").click(function(e){
			
			if (form_modificato)
			{
				if (!window.confirm("Se non salvi perderai le modifiche effettuate. Confermi il salvataggio?")) {
					
				}
				else
				{
					$(".submit_entry").find("button").trigger('click');
// 					$(".formClass").submit();
					e.preventDefault();
				}
			}
			
		});
	}
	
	$(".change_trigger").click(function(e){
		
		e.preventDefault();
		
		var value = $(this).attr("data-bulk");
		
		$(this).parent().parent().parent().find("input").prop('checked', true);
		
		$(this).parents('table').find('.bulk_actions_select').val(value).trigger('change');
		
	});
	
	$('form.main_form input[type=checkbox]').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	
	$(".submit_button").click(function(){
		
		$(this).parents("form").submit();
	});
	
	$(".filtro_files select").change(function(){
		
		$(".filtro_files").submit();
		
	});
	
	$(".list_filter_form select").change(function(){
		
		
		$(this).parents(".list_filter_form").submit();
		
	});
	
	$(".ordinamento").change(function(){
		
		var vstatus = $(this).attr("data-status");
		
		var ord = $(this).val();
		
		var id = $(this).attr("data-id");
		
		var url = baseUrl + "/" + controllerName + "/" + actionName + "/" + id + vstatus + "&ordinamento=" + ord;
		
		location.href = url;
		
	});
	
	$(".table_scaffolding tr td").click(function(e){
		
		if(e.target != this) return;
		
		if ($(this).parents("tr").find("a.action_edit").length > 0)
		{
			var url = $(this).parents("tr").find("a.action_edit").attr("href");
			location.href = url;
		}
		else if ($(this).parents("tr").find("a.action_iframe").length > 0)
		{
			$(this).parents("tr").find("a.action_iframe").trigger("click");
		}
// 		else if ($(this).parents("tr").find("a").last().length > 0)
// 		{
// 			var url = $(this).parents("tr").find("a").last().attr("href");
// 			location.href = url;
// 		}
		
	});
	
	$(".filtri_main select").change(function(){
		
		$(this).parents("form").submit();
		
	});
	
	$.fn.datepicker.defaults.language = 'it';
	
	$('.data_filtro').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true,
		format: "dd/mm/yyyy"
	});
	
	setTimeout(function(){
		
		aggiornaAltezzaIframe();
		
	}, 100);
	
	$( "body" ).on( "click", "a", function(e){
		aggiornaAltezzaIframe();
	});
	
	$(document).ajaxSuccess(function() {
		aggiornaAltezzaIframe();
	});
	
});

//-->
