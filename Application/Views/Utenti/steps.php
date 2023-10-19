<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php if (!partial()) { ?>
<?php if ($type !== "insert") { ?>

<div class="tabs-container tabs-container_my">
	<ul class="nav nav-tabs">
		<li <?php echo $posizioni['form'];?>><a href="<?php echo $this->baseUrl."/".$this->controller."/form/update/$id".$this->viewStatus;?>">Dettagli</a></li>
		<li <?php echo $posizioni['permessi'];?>><a href="<?php echo $this->baseUrl."/".$this->controller."/permessi/$id".$this->viewStatus;?>">Permessi</a></li>
	</ul>
</div>

<?php } else { ?>

<?php } ?>

<div style="clear:left;"></div>
<?php } ?>
