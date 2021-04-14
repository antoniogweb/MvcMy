<div class='verticalMenu'>
	<ul id='menuBlock'>
		<li><a href ="#">Group</a>
			<ul>
				<?php foreach ($groups_data as $group_data) {?>
				<li><a href="<?php echo url::getRoot("users/view/1/id_group/") . $group_data['adminGroups']['id_group'];?>"><?php echo $group_data['adminGroups']['name'];?></a></li>
				<?php } ?>
				<li><a href='<?php echo url::getRoot("users/view/1/all/0");?>'>All</a></li>
			</ul>
		</li>
	</ul>
</div>

<div class='usersBox'>
	<?php echo $htmlList;?>
</div>

<div class='viewFooter'>
	<div class='pageDivision'>
		<?php echo $pageList;?>
	</div>
</div>