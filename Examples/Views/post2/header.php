<html>

<header>

<title>prova</title>
<link rel="stylesheet" type="text/css" href="<?php echo url::getRoot('public/css/style.css');?>"></style>
<link rel="stylesheet" type="text/css" href="<?php echo url::getRoot('public/css/mainmenu.css');?>"></style>
<link rel="stylesheet" type="text/css" href="<?php echo url::getRoot('public/css/form.css');?>"></style>
<script type="text/javascript" src="<?php echo url::getRoot('external/jquery/jquery-1.3.2.js');?>"></script>

<script>
$(document).ready(function(){

	$("ul#menuBlock li").mouseover(function () {
		$(this).children().css({'display' : 'block'});
	});

	$("ul#menuBlock li").mouseout(function () {
		$('ul#menuBlock li ul').css({'display' : 'none'});
	});

});
</script>

</header>

<body>

<div id="container">

