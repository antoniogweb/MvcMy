<?php if (!defined('EG')) die('Direct access not allowed!'); ?>


<div class="middle-box text-center loginscreen animated fadeInDown">
	<div>
		<div></div>
		
		<p>
			<br /><br />
			<span class="errorLogin"></span>
			<br />
		</p>
		
		<?php echo $notice; ?>
		
		<form action = '<?php echo $action;?>' method = 'POST' class="m-t login" role="form">
			<input type="hidden" name="type" value="login" />
			
			<div class="form-group">
				<input class="form-control" name='email' type="text" autofocus="" placeholder="E-mail">
			</div>
			<div class="form-group">
				<input class="form-control" name='password' type="password" placeholder="Password">
			</div>
			
			<button class="btn btn-primary btn-block" type="submit">Login</button>
		</form>
	</div>
</div>
