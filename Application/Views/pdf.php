<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<style type="text/Css">
<!--
.report_entry
{
	margin-bottom:15px;
}
-->
</style>
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
	<h3><?php echo $titleReport;?></h3>
	Data documento: <b><?php echo date("d-m-Y H:i");?></b><br /><br />
	
	<?php echo $mainContent;?>
</page>
