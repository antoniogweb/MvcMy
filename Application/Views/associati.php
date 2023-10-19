<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php include($this->viewPath("ordina"));?>

<div class="row  border-bottom white-bg dashboard-header">
	<div class="col-sm-12">
		<?php if (!nobuttons()) { ?>
		<?php echo $menu;?>
		<?php } ?>
		
		<h2><?php echo ucfirst($tabella);?></h2>
		
		<ol class="breadcrumb">
			<?php if (User::has("Admin") || $this->controller != "aziende") { ?>
			<li>
				<a href="<?php echo $this->baseUrl."/".$this->controller."/main".$this->viewStatus?>">Torna alla lista</a>
			</li>
			<?php } ?>
			<li>
				<a><b><?php echo $titoloRecord;?></b></a>
			</li>
		</ol>

	</div>
</div>

<!-- Main content -->
<div class="wrapper wrapper-content">
	<div class="row">
		<div class='col-md-12'>
			<?php include($this->viewPath("form_top"));?>
			
			<?php if (isset($specchietto)) { ?>
			<?php echo $specchietto;?>
			<?php } ?>

			<?php include($this->viewPath("steps"));?>
			
			<div class="ibox float-e-margins">
				<!--<div class="ibox-title">
					<h5><?php echo $titoloRecord;?></h5>
				</div>-->
				<div class="ibox-content ibox-content-<?php echo $this->controller."_".$this->action;?>">
					
					<?php echo $notice;?>
					
					<?php include($this->viewPath("gestisci_associato"));?>
					
					<?php
					$path = ROOT."/Application/Views/".ucfirst($this->controller)."/".$this->action."_scaffold_main.php";
					$path2 = ROOT."/Application/Views/".$this->action."_scaffold_main.php";
					
					if (file_exists($path) or file_exists($path2))
					{
						include($this->viewPath($this->action."_scaffold_main"));
					}
					else
					{
						echo $main;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
