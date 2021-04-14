<!-- show the top menù -->
<div class='mainMenu'>
	<?php echo $menù;?>
</div>

<?php echo $notice;?>

<!-- start the popup menù -->
<div class="verticalMenu">
	<?php echo $popup;?>
</div>

<!-- show the table -->
<div class='recordsBox'>
	<table class="listTable">

		<tr class="listHead">
			<td class="simpleText">ID</td>
			<td class="simpleText">TITOLO</td>
			<td class="simpleText">AUTORE</td>
			<td class="moveupForm">&nbsp</td>
			<td class="movedownForm">&nbsp</td>
			<td class="editForm">&nbsp</td>
			<td class="delForm">&nbsp</td>
		</tr>

		<?php foreach ($table as $row) {?>
		<tr class="listRow">
			<td class="simpleText"><?php echo $row['post']['id'];?></td>
			<td class="simpleText"><?php echo $row['post']['titolo'];?></td>
			<td class="simpleText"><?php echo $row['post']['autore'];?></td>
			<td class="moveupForm">
				<form class='listItemForm' action='<?php echo $this->baseUrl.'/postnew/main'.$viewStatus; ?>' method='POST'>
				<input type='submit' name='moveupAction' value='Up'>
				<input type='hidden' name='id' value='<?php echo $row['post']['id'];?>'>
				</form>
			</td>
			<td class="movedownForm">
				<form class='listItemForm' action='<?php echo $this->baseUrl.'/postnew/main'.$viewStatus; ?>' method='POST'>
				<input type='submit' name='movedownAction' value='Down'>
				<input type='hidden' name='id' value='<?php echo $row['post']['id'];?>'>
				</form>
			</td>
			<td class="editForm">
				<form class='listItemForm' action='<?php echo $this->baseUrl.'/postnew/form/update'.$viewStatus; ?>' method='POST'>
				<input type='submit' name='generalAction' value='Edit'>
				<input type='hidden' name='id' value='<?php echo $row['post']['id'];?>'>
				</form>
			</td>
			<td class="delForm">
				<form class='listItemForm' action='<?php echo $this->baseUrl.'/postnew/main'.$viewStatus; ?>' method='POST'>
				<input type='submit' name='delAction' value='Delete'>
				<input type='hidden' name='id' value='<?php echo $row['post']['id'];?>'>
				</form>
			</td>
		</tr>
		<?php } ?>

	</table>
</div>

<!-- show the list of pages -->
<div class="viewFooter">
	<div class="pageList">
		<?php echo $pageList;?>
	</div>
</div>