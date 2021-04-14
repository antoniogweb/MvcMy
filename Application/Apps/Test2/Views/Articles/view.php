<div id='content'>
	<div class = 'article_box'>
		<div class='class_title'><?php echo $row['articles']['title'];?></div>
		<div class='class_author'>Written by: <?php echo $row['articles']['author'];?></div>
		<div class='abstract'><?php echo $row['articles']['abstract'];?></div>
		<div class='link_to_insert_message'><a href="<?php echo $this->baseUrl.'/messages/insert/'.$row['articles']['id'];?>">Insert a message:</a></div>
	</div>
	
	<div>
		<a href="<?php echo $this->baseUrl.'/articles/view/'.$neighbours[0]['articles']['id'];?>"><?php echo $neighbours[0]['articles']['title'];?></a> | <a href="<?php echo $this->baseUrl.'/articles/view/'.$neighbours[1]['articles']['id'];?>"><?php echo $neighbours[1]['articles']['title'];?></a>
	</div>
</div>


