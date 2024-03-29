<?php

if (!defined('EG')) die('Direct access not allowed!');

class UploadController extends BaseController {

	function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);

		$this->session('admin');

		$this->load('header_upload');
		$this->load('footer_upload');
	}

	public function thumb($fileName = "", $id = 0)
	{
		$this->clean();
		$this->s['admin']->check();
		
		$params = array(
			'imgWidth'		=>	50,
			'imgHeight'		=>	50,
			'defaultImage'	=>  null
		);
		
		$clean['dir'] = $this->request->get("directory",null,"sanitizeAll");
		$data['base'] = $this->request->get("base",null,"sanitizeAll");
		
		if (strcmp($fileName,'') !== 0)
		{
			$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiGeneriche.'/'.$data['base']."/".$clean['dir'],$params);
			$thumb->render($fileName);
		}
		else
		{
			$thumb = new Image_Gd_Thumbnail(ROOT.'/Public/Img',$params);
			$thumb->render('nofound.jpeg');
		}
	}
	
	public function main()
	{
		$this->s['admin']->check();
		
		$this->setArgKeys(array('mostra_upload:forceInt'=>1,'mostra_indietro:forceInt'=>1,'mostra_delete:forceInt'=>1,'mostra_crea:forceInt'=>1,'clean_views:forceInt'=>1,'link_immagini:forceInt'=>1,'tutti_i_tipi:forceInt'=>1,'mostra_url_completo:forceInt'=>1,'is_popup:forceInt'=>0,'use_flash:forceInt'=>0,'use_dynamic_thumbs:forceInt'=>0));
		
		$this->shift();
		
		$data['doctype'] = null;
		
		if ($this->viewArgs['clean_views'])
		{
			$this->clean();
			$data['doctype'] = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		}
		
		$params = array(
			'filesPermission'	=>	0777,
			'language'			=>	'It',
			'allowedExtensions'	=>	'png,jpg,jpeg,txt,odt,doc,pdf,zip,gif,bmp',
			'maxFileSize'		=>	10000000,
			'fileUploadKey'		=>	'userfile',
			'fileUploadBehaviour'	=>	'add_token', //can be none or add_token
			'functionUponFileNane' => 'sanitizeFileName',
		);
		
		$clean['dir'] = $this->request->get("directory",null,"sanitizeAll");
		$clean['action'] = $this->request->get("action",null,"sanitizeAll");
		$clean['file'] = $this->request->get("file",null,"sanitizeAll");
		$data['base'] = $this->request->get("base",null,"sanitizeAll");
		
		$tree = new Files_Upload($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiGeneriche.'/'.$data['base'],$params);
		
		$tree->setDirectory($clean['dir']);
		
		switch($clean['action'])
		{
			case 'delfile':
				$tree->removeFile($clean['file']);
				break;
			case 'delfolder':
				$tree->removeFolder($clean['file']);
				break;
			case 'uploadfile':
				$tree->uploadFile();
				break;
			case 'createfolder':
				$folderName = $this->request->post("folderName",null,"sanitizeAll");
				$tree->createFolder($folderName);
				break;
		}
		
// 		echo $tree->fileName;
		
		$tree->listFiles();

		$data['files'] = $tree->getFiles();
		$data['folders'] = $tree->getSubDir();
		$data['parentDir'] = $tree->getParentDir();
// 		echo $data['parentDir'];
		$data['currentDir'] = $tree->getDirectory();
// 		echo $data['currentDir'];
		$data['baseDir'] = $tree->getBase();

		$data['notice'] = $tree->notice;
		
		$uploadResult = $this->request->get('uploadResult',null,'sanitizeAll');
		
		switch($uploadResult)
		{
			case 'success':
				$data['notice'] = "<div class='executed'>Operazione eseguita</div>";
				break;
		}
		
		$this->append($data);
		$this->load('main');
	}

}
