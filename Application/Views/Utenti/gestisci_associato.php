<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<form class="form-inline form_associato" role="form" action='<?php echo $this->baseUrl."/utenti/permessi/$id".$this->viewStatus;?>' method='POST'>
	
	Aggiungi un permesso
	
	<?php echo Html_Form::select("id_permesso","",$listaPermessi,"form-control",null,"yes");?>
	
	<input class="submit_file btn btn-primary button_no_margin" type="submit" name="insertAction" value="Aggiungi">
	
</form>
