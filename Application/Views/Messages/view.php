<div id='content'>
	<?php echo $notice;?>
	
	<div class='messages'>
		<div class='mess_title'>Messages:</div>
		
		<div class='form_insert'>
			Insert a new message:
			<form action='<?php echo $action;?>' method='POST'>
				<table>
					<tr>
						<td>Name:</td>
						<td><input type='text' name='nome' value='<?php echo $values['nome'];?>'></td>
					</tr>
					<tr>
						<td>Message:</td>
						<td><textarea name='messaggio' value=''><?php echo $values['messaggio'];?></textarea></td>
					</tr>
					<tr>
						<td>Write the code below:</td>
						<td><input type='text' name='captcha' value=''></td>
					</tr>
					<tr>
						<td>&nbsp</td>
						<td><img src='<?php echo $this->baseUrl.'/image/captcha';?>'></td>
					</tr>
					<tr>
						<td><input type='submit' name='insertAction' value='send'></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>


