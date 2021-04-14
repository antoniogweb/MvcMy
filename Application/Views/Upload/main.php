<script type="text/javascript" src="<?php echo $this->baseUrl?>/External/jquery/jquery-1.3.2.min.js"></script>
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

<div class='mainMenu'>
	<?php echo $menù;?>
</div>

<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
	<input type='text' name='directory' value=''>
	<input type='submit' name='go' value='go'>
</form>

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
	<table width="100%">
		<tr class='EGbackBox'>
			<td width="5%">
				<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
					<input type='image' name='enter' src='<?php echo $this->baseUrlSrc?>/Public/Img/Icons/back.png'>
					<input type='hidden' name='directory' value='<?php echo $parentDir;?>'>
				</form>
			</td>
			<td>Current directory: <b><?php echo $currentDir;?></b></td>
			<td width="5%">&nbsp</td>
		</tr>
	<?php foreach ($folders as $folder) { ?>

		<tr class='EGfolderBox'>
			<td width="5%">
				<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
					<input type='image' name='enter' src='<?php echo $this->baseUrlSrc?>/Public/Img/Icons/folder.png'>
					<input type='hidden' name='directory' value='<?php echo $currentDir.$folder.'/';?>'>
				</form>
			</td>
			<td>Folder name:<br /><b><?php echo $folder;?></b></td>
			<td width="5%">
				<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
					<input type='image' name='enter' src='<?php echo $this->baseUrlSrc?>/Public/Img/Icons/delete.png'>
					<input type='hidden' name='delFolderAction' value='<?php echo $folder;?>'>
					<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
				</form>
			</td>
		</tr>

	<?php } ?>

	<?php foreach ($files as $file) { ?>

		<tr class='EGfileBox'>
			<td width="5%">
				<?php 
				$ext = end(explode('.', $file));
				$imgExt= array('jpg','jpeg','png','JPG','JPEG','PNG');
				if (in_array($ext,$imgExt))
				{
					echo "<a class='imageFile' href='".$this->baseUrlSrc."/media/".$currentDir.$file."'><img src='".$this->baseUrlSrc."/Public/Img/Icons/image.png'></a>\n";
				} else {
					echo "<img src='".$this->baseUrlSrc."/Public/Img/Icons/file.png'>\n";
				}
				?>
			</td>
			<td>File name:<br /><b><?php echo $this->baseUrlSrc.'/media/'.$currentDir.$file;?></b></td>
			<td width="5%">
				<form action='<?php echo $this->baseUrl?>/upload/main' method='POST'>
					<input type='image' name='enter' src='<?php echo $this->baseUrlSrc?>/Public/Img/Icons/delete.png'>
					<input type='hidden' name='delFileAction' value='<?php echo $file;?>'>
					<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
				</form>
			</td>
		</tr>

	<?php } ?>

	</table>
</div>
