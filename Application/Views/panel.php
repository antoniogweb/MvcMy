<div class="mainPanel">

	<div class='mainMenu'>
		<div class='logoutButton'>
			<a href ="<?php echo Url::getRoot('users/logout');?>">LOGOUT</a>
		</div>
	</div>

	<div class='usersLoggedList'>
		Users logged:
		<?php foreach ($logged as $user) {?>
		<b><?php echo $user.'  ';?></b>
		<?php } ?>
	</div>

	<ul class='panelApplicationList'>
		<li><a href="<?php echo Url::getRoot('category/main');?>">Categorie</a></li>
		<li><a href="<?php echo Url::getRoot('pagine/main/1');?>">Pagine</a></li>
		<li><a href="<?php echo Url::getRoot('test/articles/main');?>">Articles</a></li>
		<li><a href="<?php echo Url::getRoot('post/main');?>">Post</a></li>
		<li><a href="<?php echo Url::getRoot('users/main');?>">Gestione utenti</a></li>
		<li><a href="<?php echo Url::getRoot('groups/main');?>">Gestione gruppi</a></li>
		<li><a href="<?php echo Url::getRoot('upload/main');?>">Gestione files</a></li>
		<li><a href="<?php echo Url::getRoot('password/form');?>">Password</a></li>
		<li><a href="<?php echo Url::getRoot('box/main');?>">Boxes</a></li>
		<li><a href="<?php echo Url::getRoot('news/main');?>">News</a></li>
	</ul>
	
</div>