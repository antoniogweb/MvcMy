<?php

class ImageController extends Controller {

	public function captcha()
	{
		session_start();
		
		$params = array(
			'fontPath'	=> 	ROOT.'/External/Fonts/FreeFont/FreeMono.ttf',
			'boxHeight'	=>	70
// 			'undulation'=>	false,
// 			'align'		=>	true
		);
		
		$captcha = new Image_Gd_Captcha($params);
		$captcha->render();
	}

	public function thumb()
	{
		$basePath = ROOT.'/media/';
		$params = array(
// 			'imgWidth'		=>	150,
// 			'imgHeight'		=>	150,
			'defaultImage'	=>  '',
			'resample'		=>  'yes',
			'function'		=>	'sharpen',
		);
		
		$thumb = new Image_Gd_Thumbnail($basePath,$params);
		$thumb->render('grande_home.xcf');
		
// 		echo "It works!";
	}

	public function crop()
	{
		$basePath = ROOT.'/media/';
		$params = array(
			'imgWidth'		=>	200,
			'imgHeight'		=>	200,
			'defaultImage'	=>  '',
			'cropImage'		=>	'yes',
			'horizAlign'	=>	'left',
			'vertAlign'		=>	'center'
		);
		
		$thumb = new Image_Gd_Thumbnail($basePath,$params);
		$thumb->render('signs.jpg');
		
// 		echo "It works!";
	}

	public function tofile()
	{
		$basePath = ROOT.'/media/';
		$params = array();

		$thumb = new Image_Gd_Thumbnail($basePath,$params);
		$thumb->render('images.jpeg',"temp");

// 		echo "It works!";
	}
}