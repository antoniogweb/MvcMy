<?php if (!defined('EG')) die('Direct access not allowed!'); ?>

<div class="row  border-bottom white-bg dashboard-header">
	<div class="col-sm-12">
		<?php if (!showreport()) { ?>
		<h2>Cambia password</h2>
		<?php } ?>
	</div>
</div>

<!-- Main content -->
<div class="wrapper wrapper-content">
	<div class="row">
		<div class='col-md-12'>
			<div class="ibox float-e-margins">
				<div class="ibox-content">
					<?php echo $notice;?>

					<!-- show the table -->
					<div class='recordsBox'>
						<?php echo $form;?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>