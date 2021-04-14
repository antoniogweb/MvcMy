<script type="text/javascript" src="<?php echo $this->baseUrl?>/external/jquery/jquery-1.3.2.min.js"></script>
<script>

$(document).ready(function(){

$(".imageFile").click(function() {
	imagePath = $(this).attr("href");
	$("#imagePreview").empty();
	html = "<img height='110px' src='"+imagePath+"'>";
	$("#imagePreview").append(html);
	return false;
});

});

</script>

<div class='EGformBox'>
	<div class='EGcreateFolderBox'>
		<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
			Add a folder:
			<input type='input' name='folderName' value='folder name'>
			<input type='submit' name='createFolderAction' value='create'>
			<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
		</form>
	</div>
	
	<div class='EGuploadFileBox'>
		<form action='<?php echo $this->baseUrl?>/upload/main' method='POST' enctype="multipart/form-data">
			Upload a file:
			<input name="userfile" type="file">
			<input type="submit" name="uploadFileAction" value="upload">
			<input type="hidden" name="MAX_FILE_SIZE" value="3000">
			<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
		</form>
	</div>
</div>

<div style="height:50px;">
	<?php echo $notice;?>
</div>

<div id="imagePreview">
	
</div>

<div class='EGexternalBox'>
	<div class='EGbackBox'>
		<div class='EGbackImage'>
			<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
				<input type='image' name='enter' src='<?php echo $this->baseUrl?>/public/img/icons/back.png'>
				<input type='hidden' name='directory' value='<?php echo $parentDir;?>'>
			</form>
		</div>
		
		<div class='EGcurrentDirectory'>
			Current directory: <b><?php echo $currentDir;?></b>
		</div>
	</div>
	
	<?php foreach ($folders as $folder) { ?>

	<div class='EGfolderBox'>
		<div class='EGfolderImage'>
			<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
				<input type='image' name='enter' src='<?php echo $this->baseUrl?>/public/img/icons/folder.png'>
				<input type='hidden' name='directory' value='<?php echo $baseDir.$folder.'/';?>'>
			</form>
		</div>
		
		<div class='EGfolderName'>
			Folder name:<br /><b><?php echo $folder;?></b>
		</div>
		
		<div class='EGfolderDelImage'>
			<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
				<input type='image' name='enter' src='<?php echo $this->baseUrl?>/public/img/icons/delete.png'>
				<input type='hidden' name='delFolderAction' value='<?php echo $baseDir.$folder;?>'>
				<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
			</form>
		</div>
	</div>

	<?php } ?>

	<?php foreach ($files as $file) { ?>

	<div class='EGfileBox'>
		<div class='EGfileImage'>
			<?php 
			$ext = end(explode('.', $file));
			$imgExt= array('jpg','jpeg','png','JPG','JPEG','PNG');
			if (in_array($ext,$imgExt))
			{
				echo "<a class='imageFile' href='".$this->baseUrl."/media/".$file."'><img src='".$this->baseUrl."/public/img/icons/image.png'></a>\n";
			} else {
				echo "<img src='".$this->baseUrl."/public/img/icons/file.png'>\n";
			}
			?>
		</div>
		
		<div class='EGfileName'>
			File name:<br /><b><?php echo $this->baseUrl.'/media/'.$file;?></b>
		</div>
		
		<div class='EGfileDelImage'>
			<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
				<input type='image' name='enter' src='<?php echo $this->baseUrl?>/public/img/icons/delete.png'>
				<input type='hidden' name='delFileAction' value='<?php echo $baseDir.$file;?>'>
				<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
			</form>
		</div>
	</div>

	<?php } ?>
	
</div>