<div id='content'>
	<?php foreach ($table as $row) { ?>

	<div class = 'article_box'>
		<div class='class_title'>
			<a href="<?php echo url::getRoot('articles/view/'.$row['articles']['id']).'/'.$row['articles']['title'];?>"><?php echo $row['articles']['title'];?></a>
		</div>
		<div class='class_author'>Written by: <?php echo $row['articles']['author'];?></div>
		<div class='abstract'><?php echo $row['articles']['abstract'];?></div>
	</div>

	<?php } ?>
	<div class="pageDivision">
		<?php echo $pageList;?>
	</div>
</div>
