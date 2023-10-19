<?php if (!defined('EG')) die('Direct access not allowed!'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo App::$parentUrl;?>/Public/Js/jquery/ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo App::$parentUrl.'/Public/Css/dashboard.css?rand='.rand(1,1000);?>">
    <link rel="stylesheet" type="text/css" media="print" href="<?php echo App::$parentUrl."/Public/Css/";?>print.css" />
	
	<?php if (file_exists(ROOT."/Application/Views/header_modulo.php")) { ?>
	<?php include(ROOT."/Application/Views/header_modulo.php");?>
	<?php } ?>
	
	<script>
		var baseUrl = "<?php echo $this->baseUrl;?>";
		var parentBaseUrl = "<?php echo $parentRoot;?>";
		var controllerName = "<?php echo $this->controller;?>";
		var actionName = "<?php echo $this->action;?>";
		var viewStatus = "<?php echo $this->viewStatus;?>";
		var datePickerStartView = <?php echo $datePickerStartView;?>;
		var datePickerOrientation = "<?php echo $datePickerOrientation;?>";
		var partial = <?php echo partial() ? "true" : "false";?>;
	</script>

	<script src="<?php echo App::$parentUrl;?>/Public/Js/ajaxQueue.js"></script>
	
    <?php if (partial()) { ?>
    <style>
		.content-wrapper
		{
			margin-left:0px;
		}
		body, #wrapper
		{
			background-color:#ffffff !important
		}
    </style>
    <?php } ?>
    
    <?php if (User::$mobile) { ?>
	<style>
	.ng-scope #wrapper
	{
	  overflow-x: hidden !important;
	}
	</style>
	<?php } ?>

</head>

<body id="account-<?php echo User::has("Admin") ? "admin" : "azienda";?>" <?php if (!User::$logged) { ?>class="gray-bg middle-box <?php echo App::$bodyClass;?>"<?php } else { ?>class="fixed-sidebar <?php echo App::$bodyClass;?>"<?php } ?>>

	<div id="wrapper">
		<?php if (!partial()) { ?>
		<nav class="navbar-glm navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<?php if (User::$logged and strcmp($this->action,'logout') !== 0) { ?>
				<ul class="nav" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element"> 						
							<span class="clear"> 
								<span class="block m-t-xs"> 
									<strong class="font-bold"><?php echo t("Benvenuto");?><br /><span class="white"><?php echo $datiUtente["nome"]." ".$datiUtente["cognome"]; ?></span>
									</strong>
								</span>
							</span>
						</div>
					</li>

					<?php include($this->viewPath("menu_$sezionePannello"));?>
				</ul>
				<?php } ?>
			</div>
		</nav>
		<?php } ?>

		<div <?php if (!partial() and User::$logged and strcmp($this->action,'logout') !== 0) { ?>id="page-wrapper"<?php } else { ?>id="page-wrapper_partial"<?php } ?> class="gray-bg dashbard-1">
			<?php if (!partial() and User::$logged and strcmp($this->action,'logout') !== 0) { ?>
			<div class="row border-bottom">

				<nav class="navbar navbar-static-top navbar_ovam" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
					</div>

					<?php if (User::$logged and strcmp($this->action,'logout') !== 0) { ?>

					<ul class="nav navbar-top-links navbar-right">
						
						<?php if (file_exists(ROOT."/Application/Views/campanelle.php")) { ?>
						<?php include(ROOT."/Application/Views/campanelle.php");?>
						<?php } ?>
						
						<?php if (User::has("Admin") && !App::$modulo) { ?>
						<li class="dropdown">
							<?php if (strcmp($sezionePannello,"gestionale") === 0) { ?>
							<a class="dropdown-toggle count-info" href="<?php echo App::$parentUrl.'/panel/main/impostazioni';?>">
								<i class="fa fa-cog"></i> <?php echo t("Configurazione");?>
							</a>
							<?php } else { ?>
							<a class="dropdown-toggle count-info" href="<?php echo App::$parentUrl.'/panel/main/gestionale';?>">
								<i class="fa fa-home"></i> <?php echo t("Gestionale");?>
							</a>
							<?php } ?>
						</li>
						<?php } ?>
						
						<?php if (User::has("Admin")) { ?>
						<li class="dropdown">
							<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
								<i class="fa fa-bell"></i> <?php if ($numeroNotificheDaLeggere) { ?><span class="label label-primary"><?php echo $numeroNotificheDaLeggere;?></span><?php } ?>
							</a>
							<ul class="dropdown-menu dropdown-alerts">
								<?php
								$r = new RevisioniModel(); 
								foreach ($notificheDaLeggere as $notifica) { ?>
								<li>
									<a href="<?php echo $this->baseUrl."/revisioni/form/update/".$notifica["revisioni"]["id_revisione"]."?lid=".$notifica["revisioni"]["id_revisione"];?>">
										<div>
											<span class="pull-right text-muted small"><?php echo $notifica["revisioni"]["data_modifica"];?></span>
											<i class="fa fa-<?php echo $r->icona($notifica);?> fa-fw"></i> <?php echo $notifica["revisioni"]["descrizione"];?>
											
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<?php } ?>
								<li>
									<div class="text-center link-block">
										<a href="<?php echo $this->baseUrl."/revisioni/main";?>">
											<strong><?php echo t("Vedi tutte le notifiche");?></strong>
											<i class="fa fa-angle-right"></i>
										</a>
									</div>
								</li>
							</ul>
						</li>
						<?php } ?>
						
						<li class="dropdown">
							<a style="cursor:pointer;" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo App::$parentUrl.'/password/form';?>"><span class="glyphicon glyphicon-cog"></span> <?php echo t("Modifica password");?></a></li>
								<li><a href="<?php echo App::$parentUrl.'/utenti/logout';?>"><span class="glyphicon glyphicon-off"></span> <?php echo t("Esci");?></a></li>
							</ul>
						</li>
					</ul>

					<?php } ?>
				</nav>
			</div>
			<?php } ?>
