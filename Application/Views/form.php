<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php if ($useEditor) { ?>
<script type="text/javascript" src="<?php echo $this->baseUrl?>/Public/Js/tiny_mce/jquery.tinymce.js"></script>

<script type="text/javascript">

function ajaxfilemanager(field_name, url, type, win) {
		var ajaxfilemanagerurl = "<?php echo $this->baseUrl."/upload/main/1/1/1/1/0/0/1/0/1/0/1?base=";?>";
// 		switch (type) {
// 			case "image":
// 			ajaxfilemanagerurl = "<?php echo $this->baseUrl."/upload/main/1/1/1/1/0/0/0/0/1/0/1?base=";?>";
// 			break;
// 		}
		var fileBrowserWindow = new Array();
		fileBrowserWindow["file"] = ajaxfilemanagerurl;
		fileBrowserWindow["title"] = "Ajax File Manager";
		fileBrowserWindow["width"] = "782";
		fileBrowserWindow["height"] = "440";
		fileBrowserWindow["resizable "] = "yes";
		fileBrowserWindow["inline"] = "yes";
		fileBrowserWindow["close_previous"] = "no";
		tinyMCE.activeEditor.windowManager.open(fileBrowserWindow, {
			window : win,
			input : field_name
		});
		
		return false;
	}
	
	$().ready(function() {
		$('.editor_textarea').tinymce(tiny_editor_config);
		//$(".display_none").css({ 'display' : 'none' });
	});
	
$(document).ready(function() {

	
});
</script>
<?php } ?>

<?php if ($this->controller !== "calendariopresenze") { ?>
<div class="row  border-bottom white-bg dashboard-header">
	<div class="col-sm-12">
		<?php if (!nobuttons()) { ?>
		<?php echo $menu;?>
		<?php } ?>
		
		<?php if (!showreport()) { ?>
		<h2><?php echo ucfirst(strtolower(str_replace("_"," ",$tabella)));?></h2>
		<?php if (!nobuttons()) { ?>
		<ol class="breadcrumb">
			<?php if (User::has("Admin") || $this->controller != "aziende") { ?>
			<li>
				<a href="<?php echo $this->baseUrl."/".$this->controller."/main".$this->viewStatus?>"><?php echo t("Torna alla lista");?></a>
			</li>
			<?php } ?>
			<li>
				<a><b><?php echo $titoloRecord;?></b></a>
			</li>
		</ol>
		<?php } ?>
		<?php } ?>
	</div>
</div>
<?php } ?>

<!-- Main content -->
<div class="wrapper wrapper-content">
	<div class="row">
		<div class='col-md-12'>
			<?php include($this->viewPath("form_top"));?>
			
			<?php if (isset($specchietto)) { ?>
			<?php echo $specchietto;?>
			<?php } ?>
			
			<?php if ((!partial() || $this->controller === "ordini" || $this->controller === "anagrafiche") and file_exists(ROOT."/Application/Views/".ucfirst($this->controller)."/steps.php")) { ?>
			<?php include($this->viewPath("steps"));?>
			<?php } ?>
			
			<div class="ibox float-e-margins">
				<!--<div class="ibox-title">
					<h5><?php echo $titoloRecord;?></span>
				</div>-->
				<div class="ibox-content">

					<?php if (!showreport()) { ?>
					<?php echo $notice;?>
					<?php echo flash("notice");?>
					
					<!-- show the table -->
					<div class='scaffold_form'>
					<?php } ?>
					<?php if (!isset($queryResult) or !$queryResult) { ?>
					<?php
					$path = ROOT."/Application/Views/".ucfirst($this->controller)."/".$this->action."_scaffold_main.php";
					
					if (file_exists($path))
					{
						include($path);
					}
					else
					{
					?>
					<div class="row">
						<div class='col-md-6'>
					<?php
						echo $main;
					?>
						</div>
					</div>
					<?php
					}
					?>
					<?php } ?>
					<?php if (!showreport()) { ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
