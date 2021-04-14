<div class='mainMenu'>
	<?php echo $menu;?>
</div>

<?php echo $notice;?>

<div>
	<form action = '<?php echo $action;?>' method = 'POST'>

	<select name='id_arg'>
		<?php foreach ($argomenti as $name => $value) {?>
			<option value='<?php echo $value;?>'><?php echo $name;?></option>
		<?php } ?>
	</select>
	<br />
	<input type='submit' name='associate' value='associate'>
	<input type='submit' name='dissociate' value='dissociate'>
	</form> 
</div>