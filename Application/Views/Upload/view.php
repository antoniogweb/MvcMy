<script type="text/javascript" src="<?php echo $this->baseUrl?>/external/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl?>/public/js/LinkToForm.js"></script>

<script>

$(document).ready(function(){

	var obj = new LinkToForm("http://localhost/giant/upload/view");

	obj.traverse();

});

</script>

<div class='EGformBox'>
	<div class='EGcreateFolderBox'>
		<form action='<?php echo $this->baseUrl?>/upload/view' method='POST'>
			Add a folder:
			<input type='input' name='folderName' value='folder name'>
			<input type='submit' name='createFolderAction' value='create'>
			<input type='hidden' name='directory' value='<?php echo $currentDir;?>'>
		</form>
	</div>
	
	<div class='EGuploadFileBox'>
		<form action='<?php echo $this->baseUrl?>/upload/view' method='POST' enctype="multipart/form-data">
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

<div class="imagePreview">
	
</div>

<div class='EGexternalBox'>
	<table width="100%">

		<tr class="EGbackBox">
			<td width="5%"><a title="back" class='moveFolder' href='<?php echo $parentDir;?>'><img src='<?php echo $this->baseUrl?>/public/img/icons/back.png'></a></td>
			<td>Current directory: <b><?php echo $currentDir;?></b></td>
			<td>&nbsp</td>
		</tr>

		<?php foreach ($folders as $folder) { ?>

		<tr class="EGfolderBox">
			<td width="5%"><a class='moveFolder' href='<?php echo $baseDir.$folder.'/';?>'><img src='<?php echo $this->baseUrl?>/public/img/icons/folder.png'></a></td>
			<td>Folder name: <b><?php echo $folder;?></b></td>
			<td width="5%"><a class='delFolder' title='<?php echo $baseDir.$folder.'/';?>' href='<?php echo $currentDir;?>'><img src='<?php echo $this->baseUrl?>/public/img/icons/delete.png'></a></td>
		</tr>

		<?php } ?>
		
		<?php foreach ($files as $file) { ?>
		
		<tr class="EGfileBox">
			<td width="5%"><img src='<?php echo $this->baseUrl?>/public/img/icons/file.png'></td>
			<td>File name:<b><?php echo $this->baseUrl.'/media/'.$file;?></b></td>
			<td width="5%"><a class='delFile' title='<?php echo $baseDir.$file;?>' href='<?php echo $currentDir;?>'><img src='<?php echo $this->baseUrl?>/public/img/icons/delete.png'></a></td>
		</tr>
		
		<?php } ?>
		
	</table>
</div>