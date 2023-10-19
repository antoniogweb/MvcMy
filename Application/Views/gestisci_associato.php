<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<?php if ($this->action === "righe") { ?>

<p style="overflow:hidden;">
<!-- 	<a class="iframe badge badge-default pull-right" href="<?php echo $this->baseUrl."/prestazioni/main?partial=Y";?>"><i class="fa fa-edit"></i> Gestisci le prestazioni</a> -->
	
	<?php if ($this->controller === "fatture") { ?>
	<a class="btn btn-primary btn-sm btn-rounded iframe" href="<?php echo $this->baseUrl."/righe/main/?partial=Y&nobuttons=Y&id_azienda=".$documento["id_azienda"];?>&tipodoc=O&id_doc=<?php echo $id;?>"><i class='fa fa-plus-square-o'></i> <?php echo t("Importa righe offerta");?></a>
	<?php } ?>
	<a class="btn btn-info btn-sm btn-rounded iframe" href="<?php echo $this->baseUrl."/prestazioni/main/?partial=Y&nobuttons=Y&id_doc=$id&attivo=Y";?>"><i class='fa fa-plus-square-o'></i> <?php echo t("Importa prestazioni");?></a>
	<a class="btn btn-default btn-sm btn-rounded iframe" href="<?php echo $this->baseUrl."/righe/form/insert/0/?partial=Y&nobuttons=Y&id_doc=$id&attivo=Y";?>"><i class='fa fa-plus-square-o'></i> <?php echo t("Aggiungi riga libera");?></a>
	
</p>

<?php } ?>

<?php if ($this->action === "mail") { ?>

<?php
$docObj = new DocumentiModel();
$doc = $docObj->selectId((int)$id);
?>

<?php if ($doc["email_amministrativa"] !== "") { ?>
<a class="btn btn-info btn-sm btn-rounded iframe" href="<?php echo $this->baseUrl."/mail/form/insert/0?partial=Y&nobuttons=Y&id_doc=$id&attivo=Y";?>"><i class='fa fa-plus-square-o'></i> <?php echo t("Invia mail");?></a>
<br /><br />
<?php } ?>

<?php } ?>
