<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php if (User::has("Admin")) { ?>
<li class="<?php echo getActive($tm,"utenti");?> voce_li">
	<a href="<?php echo $this->baseUrl;?>/utenti/main" class="voce"><i class="fa fa-folder"></i> <span class="nav-label"><?php echo t("Utenti");?></span></a>
	<a href="<?php echo $this->baseUrl;?>/utenti/form/insert/0" class="add">
		<i class="fa fa-plus-square-o"></i>
	</a>
</li>
<li class="<?php echo getActive($tm,"revisioni");?> voce_li">
	<a href="<?php echo $this->baseUrl;?>/revisioni/main"><i class="fa fa-bell"></i> <span class="nav-label"><?php echo t("Notifiche");?></span></a>
</li>
<li class="<?php echo getActive($tm,"logmail");?> voce_li">
	<a href="<?php echo $this->baseUrl;?>/logmail/main"><i class="fa fa-list"></i> <span class="nav-label"><?php echo t("Log email");?></span></a>
</li>
<li class="<?php echo getActive($tm,"impostazioni");?>">
	<a href="<?php echo $this->baseUrl;?>/impostazioni/form/update/1"><i class="fa fa-cogs"></i> <span class="nav-label"><?php echo t("Impostazioni");?></span></a>
</li>
<?php } ?>
