<?php

// EasyGiant is a PHP framework for creating and managing dynamic content
//
// Copyright (C) 2009 - 2014  Antonio Gallo (info@laboratoriolibero.com)
// See COPYRIGHT.txt and LICENSE.txt.
//
// This file is part of EasyGiant
//
// EasyGiant is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// EasyGiant is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with EasyGiant.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

//module to print an HTML image linking to something
//extends the ModBase class
class ModLinkimage extends ModImage {
	
	public function render()
	{
		$link = "<a ".$this->getHtmlClass()." href='".$this->simpleXmlObj->href[0]."'><img ".$this->widthPropertyString().$this->heightPropertyString().$this->titlePropertyString()." src='".$this->simpleXmlObj->src[0]."'></a>";
		return $this->wrapDiv($link)."\n";
	}
	
}