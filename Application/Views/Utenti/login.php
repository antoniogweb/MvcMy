<?php if (!defined('EG')) die('Direct access not allowed!'); ?>


<div class="middle-box text-center loginscreen animated fadeInDown">
	<div>
		<div></div>
		
		<!--<h3>Welcome to Articms</h3>
		<p>Login in. To see it in action.</p>-->
		
		<p>
<!-- 			<img width="100px" src="<?php echo $this->baseUrl."/Public/Img/logo_nsl.png"?>" /> -->
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
			
<!-- 			<br /> -->
<!-- 			<a href="javascript: void($('.recuperaPsw').slideToggle());"><small>Recupera la password</small></a> -->
		</form>
		
		<!--<form class="m-t recuperaPsw hiddenBlock" role="form" action="" method="post">
			<input type="hidden" name="recuperaPassword" value="recuperaPassword" />
			
			<div class="form-group">
				<input type="email" class="form-control" placeholder="E-mail" required="" name="email" value="">
			</div>
			<button type="submit" class="btn btn-primary block full-width m-b">Recupera</button>
		</form>-->
					
<!-- 		<p class="m-t"> <small>ArtiCMS 3.0</small> </p> -->
	</div>
</div>
