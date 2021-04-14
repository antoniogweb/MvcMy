<?php

// All EasyGiant code is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// See COPYRIGHT.txt and LICENSE.txt.

class UploadController extends Controller {

	public function __construct($model, $controller, $queryString)
	{
		$this->helper('Menu','upload','panel');
		$this->session('admin');
		parent::__construct($model, $controller, $queryString);
	}

	public function main()
	{

		$this->s['admin']->check('file,root');

		$params = array(
			'filesPermission'	=>	0777,
			'language'			=>	'It',
			'allowedExtensions'	=>	'png,jpg,jpeg,txt,odt,doc',
			'maxFileSize'		=>	3000000,
			'fileUploadKey'		=>	'userfile'
		);
		
		$tree = new Files_Upload(ROOT.'/media',$params);

// 		$tree->setString("executed","<div class='executed'>Fatto!</div>\n");

		$dir = isset($_POST['directory']) ? $_POST['directory'] : null;
		$tree->setDirectory($dir);
		
		$tree->updateTree();
		
		echo $tree->fileName;
		
		$tree->listFiles();

		$data['files'] = $tree->getFiles();
		$data['folders'] = $tree->getSubDir();
		$data['parentDir'] = $tree->getParentDir();
// 		echo $data['parentDir'];
		$data['currentDir'] = $tree->getDirectory();
// 		echo $data['currentDir'];
		$data['baseDir'] = $tree->getBase();
		
		$data['notice'] = $tree->notice;
		$data['menù'] = $this->h['Menu']->render('panel');
		
		$this->set($data);
		$this->load('header');
		$this->load('main');
		$this->load('footer');
	}

	public function view()
	{
		$params = array(
			'filesPermission'=>0777
		);
		$tree = new Files_Upload(ROOT.'/media/',$params);

		$tree->updateTree();
		$tree->listFiles();

		$data['files'] = $tree->getRelFiles();
		$data['folders'] = $tree->getRelSubDir();
		$data['parentDir'] = $tree->getParentDir();
		$data['currentDir'] = $tree->getDirectory();
		$data['baseDir'] = $tree->getBase();
		
		$data['notice'] = $tree->notice;

		$this->set($data);
		$this->load('header');
		$this->load('view');
		$this->load('footer');
	}

	public function test()
	{
		$tree = new Files_Upload(ROOT.'/media');
		
// 		echo $tree->getDirectory()."<br />";
// 		
// 		$dir = ROOT.'/media/.svn/';
// 		if ($tree->setDirectory($dir))
// 		{
// 			echo "operazione eseguita!<br />";
// 			echo $tree->getDirectory()."<br />";
// 		}
// 		if (!$tree->removeFolder(null))
// 		{
// 			echo $tree->notice;
// 		}
		
		$tree->setDirectory('.svn');
// 		echo $tree->notice;
		$tree->listFiles();
// 		$files = $tree->getRelFiles();
// 		foreach ($files as $file)
// 		{
// 			echo $file."<br />";
// 		}
		echo $tree->getParentDir()."<br />";
		echo "ciao";
	}

}