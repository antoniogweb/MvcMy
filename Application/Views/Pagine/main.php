<!-- show the top menù -->
<div class='mainMenu'>
	<?php echo $menù;?>
</div>

<?php echo $notice;?>

<!-- start the popup menù -->
<div class="verticalMenu">
	<ul onMouseOver='DisplayTag(this,"block");' onMouseOut='DisplayTag(this,"none");' id='menuBlock'><li class='innerItem'><b>CATEGORIA</b><ul class='innerList'>
	<?php 
	foreach ($popup as $field => $value)
	{
		echo "<li><a href='".$this->baseUrl."/pagine/main/1/".$value."'>".$field."</a></li>\n";
	}
	echo "<li><a href='".$this->baseUrl."/pagine/main/1/undef'>All</a></li>\n";
	?>
	</ul></li></ul>
	<script type="text/javascript" src="<?php echo $this->baseUrlSrc;?>/Public/Js/DisplayTag.js"></script>
</div>

<!-- show the table -->
<div class='recordsBox'>
	<?php echo $main;?>
</div>

<!-- show the list of pages -->
<div class="viewFooter">
	<div class="pageList">
		<?php echo $pageList;?>
	</div>
</div>
