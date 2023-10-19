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

class Lang_It_Formats_Fields extends Lang_En_Formats_Fields
{
	
	public static function getLabel($fieldName)
	{
		if (strstr($fieldName,","))
		{
			$temp = explode(",",$fieldName);
			for ($i=0; $i< count($temp); $i++)
			{
				$temp[$i] = self::getLabel($temp[$i]);
			}
			return implode (" , ",$temp);
		}
		else
		{
			$fieldName = str_replace("_medico","",$fieldName);
			$fieldName = str_replace("_consulente","",$fieldName);
			$fieldName = str_replace("_commercialista","",$fieldName);
			$fieldName = str_replace("_operativo","",$fieldName);
			
			$fieldName = str_replace("_tutore","",$fieldName);
			$fieldName = str_replace("_cell_1","",$fieldName);
			$fieldName = str_replace("_cell_2","",$fieldName);
			
			$fieldName = str_replace("numero_identificazione","N° identificazione",$fieldName);
			
			$fieldName = str_replace("provincia","prov.",$fieldName);
			
			$fieldName = str_replace("familiarita","familiarità",$fieldName);
			
			if (strcmp($fieldName,"invalidita") === 0) return "Invalidità";
			
			if (strcmp($fieldName,"id_datore") === 0) return "Datore di lavoro";
			
			if (strcmp($fieldName,"titolo") === 0) return "Titolo (*)";
			if (strcmp($fieldName,"ragione_sociale") === 0) return "Ragione sociale (*)";
			if (strcmp($fieldName,"abbreviazione") === 0) return "Abbreviazione (*)";
// 			if (strcmp($fieldName,"cell_1") === 0) return "Cell 1 (*)";
			
			if (strcmp($fieldName,"numero_civico") === 0) return "N°";
			if (strcmp($fieldName,"numero_civico_domicilio") === 0) return "N°";
			if (strcmp($fieldName,"cap_domicilio") === 0) return "Cap";
			
			if (strcmp($fieldName,"p_iva") === 0) return "P. IVA";
			
			if (strcmp($fieldName,"localita") === 0) return "Località";
			
			if (strcmp($fieldName,"title") === 0) return "Titolo";
			if (strcmp($fieldName,"keywords") === 0) return "Parole chiave (divise da virgola)";
			if (strcmp($fieldName,"meta_description") === 0) return "Descrizione per motori di ricerca";
			if (strcmp($fieldName,"add_in_sitemap") === 0) return "Mostra in sitemap";
			
			if (strcmp($fieldName,"durata") === 0) return "Durata (in ore)";
			
			if (strcmp($fieldName,"attiva_per_azienda") === 0) return "Attivo";
			
			
			$fieldName = str_replace("_"," ", $fieldName);
			
			return ucfirst($fieldName);
		}
	}
	
}
