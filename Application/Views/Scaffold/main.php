<!-- FILTERS -->
<?php if (count($filters) > 0) { ?>
<form action="<?php echo $this->baseUrl."/".$this->controller."/".$this->action;?>" method="GET">
	<?php foreach ($filters as $f) { ?>
		
		<?php if (isset(Filters::$elements[$f]) and isset($this->viewArgs[$f])) { ?>
			<?php if (strcmp(Filters::$elements[$f]["type"],"select") === 0 ) { ?>
				<?php echo Html_Form::select($f,$this->viewArgs[$f], Filters::$elements[$f]["options"], null,null, "yes",Filters::getAttributes($f)); ?>
			<?php } else { ?>
				<?php
				$value = strcmp($this->viewArgs[$f],Params::$nullQueryValue) === 0 ? "" : $this->viewArgs[$f];
				echo Html_Form::input($f,$value,null,null,Filters::getAttributes($f));
				?>
			<?php } ?>
		<?php } ?>
		
	<?php } ?>
	
	<button>Vai</button>
</form>
<?php } ?>
<!-- FILTERS -->

<!-- VIEW -->
<?php if (count($view) > 0) { ?>
<?php
$setBulk = false;
if (!empty($bulkActions) and isset($view[0]["__ID__"])) { $setBulk = true; } ?>
<?php if ($setBulk) { ?>
<form action="<?php echo $this->baseUrl."/".$this->controller."/".$this->action.$this->viewStatus;?>" method="POST">
<?php } ?>
	<table class="listTable">
		<?php
		$colunms = array_keys($view[0]);
		?>
		<thead>
			<tr>
				<?php if ($setBulk) { ?><th><input type="checkbox"></th><?php } ?>
				<?php foreach ($colunms as $col) { ?>
					<?php if ($col !== "__ID__") { ?>
					<th><?php echo $col;?></th>
					<?php } ?>
				<?php } ?>
				<?php if (isset($view[0]["__ID__"])) { ?>
				<th>&nbsp</th>
				<th>&nbsp</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php if ($setBulk) { ?>
			<tr>
				<td colspan = "<?php echo (count($colunms)+2);?>">
					Azioni di gruppo:
						<?php echo Html_Form::select("bulk_action","", $bulkActions, null,null, "yes"); ?>
						<button>Vai</button>
				</td>
			</tr>
			<?php } ?>
			<?php foreach ($view as $r) { ?>
			<tr>
				<?php if ($setBulk) { ?><th><input name="id" value="<?php echo $r["__ID__"];?>" type="checkbox"></th><?php } ?>
				<?php foreach ($colunms as $col) { ?>
					<?php if ($col !== "__ID__") { ?>
					<td><?php echo $r[$col];?></td>
					<?php } ?>
				<?php } ?>
				<?php if (isset($view[0]["__ID__"])) { ?>
				<td><a href="<?php echo $this->baseUrl."/".$this->controller."/form/".$r["__ID__"];?>">Edit</a></td>
				<td><a href="<?php echo $this->baseUrl."/".$this->controller."/".$this->action.$this->viewStatus."&del=".$r["__ID__"];?>">Del</a></td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
<?php if ($setBulk) { ?>
</form>
<?php } ?>
<?php } else { ?>
<p>Non è stato trovato alcun elemento</p>
<?php } ?>
<!-- VIEW -->

<!-- PAGINATION -->
<?php
$toNumber = $numberOfRecords;

if ($numberOfRecords > $recordsPerPage) {
	$toNumber = (($currentPage-1)*$recordsPerPage)+$recordsPerPage;
}
?>

<p>
Visualizzazione delle righe da <?php echo (($currentPage-1)*$recordsPerPage)+1;?> a <?php echo $toNumber;?> di <?php echo $numberOfRecords; ?>
</p>

<?php if ($numberOfRecords > $recordsPerPage) { ?>
<ul>
	<?php for ($i=($currentPage-3); $i <= ($currentPage+3); $i++) { ?>
		
		<?php if ($i > 0 and $i <= $numberOfPages) { ?>
		<a class='<?php echo strcmp($i, $currentPage) === 0 ? "current" : ""?>' href="<?php echo $this->baseUrl."/".$this->controller."/".$this->action.Url::create($this->viewArgs,array("page"=>$i));?>"><?php echo $i?></a>
		<?php } ?>

	<?php } ?>
</ul>
<?php } ?>
<!-- PAGINATION -->

