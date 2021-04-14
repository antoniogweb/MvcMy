<div class='mainMenu'>
	<?php echo $menù;?>
</div>

<?php echo $notice;?>

<form name = 'myForm' action='<?php echo $action;?>' method='POST'>

	<table>
		<tr>
			<td>Username</td>
			<td><input type = 'text' name = "username" value = '<?php echo $values['username'];?>'></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type = 'text' name = "password"></td>
		</tr>
		<tr>
			<td>Password confirmation</td>
			<td><input type = 'text' name = "confirmation"></td>
		</tr>
		<tr>
			<td><input type = 'submit' name = 'scelta' value = 'save'></td>
		</tr>
	</table>

</form>