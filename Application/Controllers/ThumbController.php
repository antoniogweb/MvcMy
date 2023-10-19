<?php

if (!defined('EG')) die('Direct access not allowed!');

class ThumbController extends BaseController {

	public function __construct($model, $controller, $queryString, $application, $action) {
		parent::__construct($model, $controller, $queryString, $application, $action);
		
		$this->session('admin');
		$this->s['admin']->check();

		$this->model('ImmaginiModel');
		
	}

	public function contenuto($image)
	{
		$this->clean();
		
		if (accepted($image))
		{
			$image = sanitizeAll($image);
			$params = array(
				'imgWidth'		=>	120,
				'imgHeight'		=>	120,
				'defaultImage'	=>  null,
				'cropImage'		=>	'no',
			);

			$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiContenuti,$params);
			$thumb->render($image);
		}
	}
	
	public function mainimage($image)
	{
		$this->clean();
		
		if (accepted($image))
		{
			$image = sanitizeAll($image);
			$params = array(
				'imgWidth'		=>	400,
				'imgHeight'		=>	400,
				'defaultImage'	=>  null,
				'cropImage'		=>	'no',
			);

			$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiContenuti,$params);
			$thumb->render($image);
		}
	}
	
	public function immagineinlistaprodotti($id_page, $fileName = null)
	{
		$clean["id_page"] = (int)$id_page;
		
		$this->clean();
		
		if (!isset($fileName))
		{
			$fileName = $this->m["ImmaginiModel"]->getFirstImage($clean["id_page"]);
		}
		
		if (accepted($fileName) or strcmp($fileName,'') === 0)
		{
			$params = array(
				'imgWidth'		=>	60,
				'imgHeight'		=>	60,
				'defaultImage'	=>  null,
				'cropImage'		=>	'yes',
				'horizAlign'	=>	'center',
				'vertAlign'		=>	'center',
			);
			
			if (strcmp($fileName,'') !== 0)
			{
				$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiContenuti,$params);
				$thumb->render($fileName);
			}
			else
			{
				$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/Public/Img',$params);
				$thumb->render('nofound.jpeg');
			}
		}
	}
	
	public function news($fileName)
	{
		$this->clean();
		
		$params = array(
			'imgWidth'		=>	100,
			'imgHeight'		=>	150,
			'defaultImage'	=>  null
		);
		
		if (strcmp($fileName,'') !== 0)
		{
			$thumb = new Image_Gd_Thumbnail($this->parentRootFolder.'/'.Parametri::$cartellaImmaginiNews,$params);
			$thumb->render($fileName);
		}
		else
		{
			$thumb = new Image_Gd_Thumbnail(ROOT.'/Public/Img',$params);
			$thumb->render('nofound.jpeg');
		}
	}
}
