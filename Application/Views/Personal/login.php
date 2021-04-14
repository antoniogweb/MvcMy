<?php echo $notice; ?>

<div class="login_box">
	<form action = '<?php echo $action;?>' method = 'POST'>
	
		<table>
			<tr>
				<td>Username</td>
				<td><input type='text' name='username'></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type='password' name='password'></td>
			</tr>
			<tr>
				<td><input type = 'submit' value = 'login'></td>
			</tr>
		</table>
	
	</form>
</div>
