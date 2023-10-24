<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php
	$topCercaValue = (isset($this->viewArgs[$topCercaName]) && (strcmp($this->viewArgs[$topCercaName],Params::$nullQueryValue) !== 0) || $this->viewArgs[$topCercaName] != "") ? $this->viewArgs[$topCercaName] : "";
	
	if (!isset($filtruSuoperioreAction)) $filtruSuoperioreAction = "main";
?>
<form action="<?php echo $this->baseUrl."/".$this->controller."/$filtruSuoperioreAction";?>" class="form-inline filtro_superiore">
	<div class="form-group pull-right">
		<input id="list_filter_input_cerca" class="form-control" placeholder="<?php echo $topCercaName;?>" type="text" name="<?php echo $topCercaName;?>" value="<?php echo $topCercaValue;?>">
		<?php foreach ($this->viewArgs as $key => $value) {
			if ($key === $topCercaName) continue;
		?>
		<input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
		<?php } ?>
		<button type="submit" class="btn btn-info btn-rounded"><i class='fa fa-search'></i></button>
	</div>
</form>
