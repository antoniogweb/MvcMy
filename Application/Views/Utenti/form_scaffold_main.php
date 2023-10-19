<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<form  class="form-horizontal main_form form_anagrafiche" method="POST" action="<?php echo $this->baseUrl."/".$this->controller."/form/$queryType/$id".$this->viewStatus;?>">
	<div class='row'>
		<div class='col-md-6'>
			<?php echo $form["email"];?>
			
			<?php echo $form["attivo"];?>
			
			<?php echo $form["nome"];?>
			
			<?php echo $form["cognome"];?>
			
			<?php echo $form["password"];?>
			
			<?php echo $form["confirmation"];?>
		</div>
	</div>
	
	<?php if (!showreport()) { ?>
	<div class='col-md-6'>
		<div class="submit_entry">
			<span class="submit_entry_Salva">
				<button id="<?php echo $type;?>Action" class="btn btn-primary btn-rounded" name="<?php echo $queryType;?>Action" type="submit"><?php if (eq($queryType,"update")) { ?><?php echo t("Modifica account");?><?php } else { ?><?php echo t("Crea account");?><?php } ?></button>
				<input type="hidden" value="Salva" name="<?php echo $queryType;?>Action">
			</span>
		</div>
	</div>
	<?php } ?>
</form>
