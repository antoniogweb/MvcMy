<div class='mainMenu'>
	<?php echo $menu;?>
</div>

<?php echo $notice;?>

<div>
	<form action = '<?php echo $action;?>' method = 'POST'>

	<select name='boxIdentifier'>
		<?php foreach ($argomenti as $name => $value) {?>
			<option value='<?php echo $value;?>'><?php echo $name;?></option>
		<?php } ?>
	</select>
	<input type='submit' name='associateAction' value='associate'>
	<input type='submit' name='dissociateAction' value='dissociate'>
	</form> 
</div>