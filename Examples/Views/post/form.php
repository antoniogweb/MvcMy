<div class='mainMenu'>
	<?php echo $topMenu;?>
</div>

<?php echo $notice; ?>

<div>
	<form action='<?php echo $action;?>' method='POST'>
		<table>
			<tr>
				<td>Titolo:</td>
				<td><input type='text' name='titolo' value='<?php echo $values['titolo'];?>'></td>
			</tr>
			<tr>
				<td>Autore:</td>
				<td><input type='text' name='autore' value='<?php echo $values['autore'];?>'></td>
			</tr>
			<tr>
				<td>Titolo:</td>
				<td><textarea name='testo'><?php echo $values['testo'];?></textarea></td>
			</tr>
			<?php echo $hidden;?>
			<tr>
				<td><input type='submit' name='<?php echo $submit;?>' value='salva'></td>
			</tr>
		</table>
	</form>
</div> 
