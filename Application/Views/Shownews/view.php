<?php
		foreach($table as $row)
		{
			echo "<a href=''">.$row['news']['title']."</a><br />";
		}
		
?>

<a href="<?php echo $this->baseUrl?>/post/main/<?php echo $row['news']['title'];?>">test</a>