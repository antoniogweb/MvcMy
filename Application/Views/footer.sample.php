<?php if (!defined('EG')) die('Direct access not allowed!'); ?>
				<?php if (!partial()) { ?>
				<div class="footer">
					<div class="pull-right">
						
					</div>
					<div>
						<b>Copyright</b> <?php echo date("Y");?>
					</div>
				</div>
				<?php } ?>
			</div><!-- /.content-wrapper -->
		</div>
		
<!--			</div>
		</div>
	</div>-->

	<div id="my_modal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo $titoloIframe;?></h4>
			</div>
			<div class="modal-body">
				<iframe class="dialog_iframe" src="" frameborder="0" height="600px" width="99.6%"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
			</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!--more icons-->
	<link href="<?php echo App::$parentUrl?>/Public/Css/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	
	<?php if (file_exists(ROOT."/Application/Views/footer_modulo.php")) { ?>
	<?php include(ROOT."/Application/Views/footer_modulo.php");?>
	<?php } ?>
	
<?php
if (isset($_GET["partial"]) and $queryResult) { ?>
<!--<script>
	window.opener.closedd = true;
	window.closed = true;
	window.close();
</script>-->
<?php } ?>

</body>
</html>
<!-- <pre> -->
<?php
// $mysqli = Db_Mysqli::getInstance();
// print_r($mysqli->queries);
?>
<!-- </pre> -->
