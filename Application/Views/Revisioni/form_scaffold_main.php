<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<form id="fileupload" data-id-anag="<?php echo $id;?>" class="form-horizontal main_form form_anagrafiche" method="POST" action="<?php echo $this->baseUrl."/".$this->controller."/form/$type/$id".$this->viewStatus;?>">
	
	<div class='row'>
		<div class='col-md-12 riga_intestazione'>
			<h2 class="center"><?php echo t("Descrizione revisione");?></h2>
			<?php if (!partial()) { ?><a class="badge badge-info" href="<?php echo $link_elemento;?>"><?php echo t("Vai all'elemento");?> <i class="fa fa-arrow-right"></i></a><?php } ?>
		</div>
	</div>
	
	<div class='row'>
		<div class='col-md-12'>
			<?php echo $form["descrizione"];?>
			
			<div class="report_entry report_entry_form_inputtext form_input_text">
				<div class="entryLabel"><b>Modifiche:</b></div>
				<div class="report_field report_field_descrizione">
					<table class="table table-striped">
						<tr>
							<th><?php echo t("Campo");?></th>
							<th><?php echo t("Prima");?></th>
							<th><?php echo t("Dopo");?></th>
						</tr>
						<?php foreach ($differenze as $field => $diff) {
							if ($field == "cerca") continue;
						?>
						<tr>
							<td><?php echo getFieldLabel($field);?></td>
							<td><del><?php echo $diff[0];?></del></td>
							<td><?php echo $diff[1];?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	
</form>
