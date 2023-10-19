<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php include($this->viewPath("ordina"));?>

<div class="row  border-bottom white-bg dashboard-header">
	<div class="col-sm-12">
		<?php if (!nobuttons()) { ?>
		<?php echo $menu;?>
		<?php include($this->viewPath("filtro_superiore"));?>
		<?php } ?>
		<h2><?php echo ucfirst(strtolower(str_replace("_"," ",$tabella)));?></h2>
		
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo $this->baseUrl."/".$this->controller."/main".$this->viewStatus?>"><?php echo t("Lista");?></a>
			</li>
		</ol>
	</div>
</div>

<!-- Main content -->
<div class="wrapper wrapper-content">
	<div class="row">
		<div class='col-md-<?php echo $larghezzaView?>'>
			<div class="ibox float-e-margins">
				<div class="ibox-content ibox-content-<?php echo encodeUrl($tabella);?> ibox-content-<?php echo encodeUrl($tabella);?>">
					<?php
					$path = ROOT."/Application/Views/".ucfirst($this->controller)."/".$this->action."_filtri.php";
					
					if (file_exists($path))
					{
						include($path);
					}
					else
					{
						echo $filtri;
					}
					?>
					
					<?php
					$path = ROOT."/Application/Views/".ucfirst($this->controller)."/main_action.php";
					
					if (file_exists($path))
					{
						include($path);
					}
					?>
					
					<?php echo $notice;?>
					
					<?php echo $main;?>
				</div>
			</div>
		</div>
	</div>
	
	<!-- show the list of pages -->
	<div class="row">
		<div class="col-lg-12">
			<?php if ($numeroElementi > $recordPerPage) { ?>
			<div class="btn-group pull-right">
				<ul class="pagination no_vertical_margin">
					<?php echo $pageList;?>
				</ul>
			</div>
			<?php } ?>
			
			<?php
			$toNumber = $numeroElementi;
			$page = $this->viewArgs["page"];
			
			if ($numeroElementi > $recordPerPage) {
				$toNumber = (($page-1)*$recordPerPage)+$recordPerPage;
			}
			?>
			<div class="lista_pagine dataTables_info" id="DataTables_Table_0_info" role="alert" aria-live="polite" aria-relevant="all"><?php echo t("Visualizzazione dei record da");?> <?php echo (($page-1)*$recordPerPage)+1;?> <?php echo t("a");?> <?php echo $toNumber;?> <?php echo t("di");?> <?php echo $numeroElementi;?></div>
		</div>
	</div>
</div>
