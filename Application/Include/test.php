<?php

if (!defined('EG')) die('Direct access not allowed!');


function my_date($timestamp)
{
	return date('d-m-Y',strtotime($timestamp));
}

function my_md5($string)
{
	return md5($string);
}

function sharpen($img)
{
	ImageConvolution($img, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);

	return $img;
}