<div class='mainMenu'>
	<?php echo $menu;?>
</div>

<?php echo $notice;?>

<div class='groupsList'>
	Associate the user <b><?php echo $user;?></b> to some groups:<br /><br />
	<form action = '<?php echo $action;?>' method = 'POST'>

	<select name='boxIdentifier'>
		<?php foreach ($groups as $name => $value) {?>
			<option value='<?php echo $value;?>'><?php echo $name;?></option>
		<?php } ?>
	</select>
	<input type='submit' name='associateAction' value='associate'>
	<input type='submit' name='dissociateAction' value='dissociate'>
	<input type='hidden' name='id_user' value='<?php echo (int)$_POST['id_user'];?>'>
	</form> 
</div>

<br /><hr>
<div class='groupsList'>
	The user <b><?php echo $user;?></b> is inserted inside the following Groups:
	<ul>
		<?php foreach ($groupsUser as $g) {?>
		<li><?php echo $g['admingroups']['name'];?></li>
		<?php } ?>
	</ul>
</div>