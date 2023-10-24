<?php

// MvcMy is a flexible and easy-to-use PHP MVC framework to use together with MvcMyLibrary
// Copyright (C) 2009 - 2023  Antonio Gallo (info@laboratoriolibero.com)
// See LICENSE.txt.
// 
// This file is part of MvcMy
// 
// MvcMy is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// MvcMy is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with MvcMy.  If not, see <http://www.gnu.org/licenses/>.

if (!defined('EG')) die('Direct access not allowed!');

function encodeUrl($url)
{
// 	$url = utf8_decode(html_entity_decode($url,ENT_QUOTES,'UTF-8'));
	
	$url = html_entity_decode($url,ENT_QUOTES,'UTF-8');
	$url = mb_convert_encoding($url, 'ISO-8859-1', 'UTF-8');
	
	$temp = null;
	for ($i=0;$i<strlen($url); $i++)
	{
		if (strcmp($url[$i],' ') === 0)
		{
			$temp .= '-';
		}
		else
		{
			if (preg_match('/^[a-zA-Z_0-9\-]$/',$url[$i]))
			{
				$temp .= $url[$i];
			}
			else
			{
				$temp .= '-';
			}
		}
	}

	$temp = str_replace("--","-",$temp);
	$temp = str_replace("--","-",$temp);
	
	if (strcmp($temp,"") === 0)
	{
		$temp = "a";
	}
	
	$temp = urlencode(strtolower($temp));
	return $temp;
}

function sanitizeFileName($imageName)
{
	$imageName = str_replace(' ','_',$imageName);

	if (preg_match('/^[a-zA-Z0-9_\-]+$/',$imageName) and strcmp(trim($imageName),'') !== 0)
	{
		return $imageName;
	}
	else
	{
		return 'file';
	}
}

function accepted($fileName)
{
	if (preg_match('/^[a-zA-Z0-9_\-]+\.(jpg|jpeg|gif|png)$/i',$fileName))
	{
		return true;
	}
	return false;
}

function reverseData($data)
{
	$data = explode('-',$data);
	krsort($data);
	$data = implode('-',$data);
	return $data;
}

function reverseDataSlash($data)
{
	$data = explode('/',$data);
	krsort($data);
	$data = implode('-',$data);
	return $data;
}

function smartDate($uglyDate = null)
{
	return date('d/m/Y',strtotime($uglyDate));
}

function reverseDataSlash2($data)
{
	$data = explode('-',$data);
	krsort($data);
	$data = implode('/',$data);
	return $data;
}

function checkDateItaliano($data)
{
	return checkIsoDate(reverseDataSlash($data));
}

function htmlentitydecode($value)
{
	return html_entity_decode($value, ENT_QUOTES, "UTF-8");
}

function htmlentitydecodeDeep($value) {
	return array_map('htmlentitydecode', $value);
}

function urlPlusEncode($value)
{
	$value = urlencode($value);
	return str_replace("%2F", "/", $value);
// 	return str_replace('+', '%2B', $value);
}

function urlPlusEncodeDeep($value) {
	return array_map('urlPlusEncode', $value);
}

function checkHttp($string)
{
// 	$protocol = Params::$useHttps ? "https" : "http";
	
	if (!stristr($string,"https://") and !stristr($string,"http://"))
	{
		return "http://".$string;
	}
	
	return $string;
}

function partial()
{
	if (isset($_GET["partial"]) and strcmp($_GET["partial"],"Y") === 0)
	{
		return true;
	}
	
	return false;
}

function nobuttons()
{
	if (isset($_GET["nobuttons"]) and strcmp($_GET["nobuttons"],"Y") === 0)
	{
		return true;
	}
	
	return false;
}

function showreport()
{
	if (isset($_GET["report"]) and strcmp($_GET["report"],"Y") === 0)
	{
		return true;
	}
	
	return false;
}

function skipIfEmpty()
{
	if (isset($_GET["skip"]) and strcmp($_GET["skip"],"Y") === 0)
	{
		return true;
	}
	
	return false;
}

function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}



function sanitizeJs($jsString)
{
	$result = strtr($jsString, array('\\' => '\\\\', "'" => "\\'", '"' => '\\"', "\r" => '\\r', "\n" => '\\n' ));
	
	return $result;
}

function translate($string)
{
	$string = preg_replace('/(January)/', 'Gennaio',$string);
	$string = preg_replace('/(February)/', 'Febbraio',$string);
	$string = preg_replace('/(March)/', 'Marzo',$string);
	$string = preg_replace('/(April)/', 'Aprile',$string);
	$string = preg_replace('/(May)/', 'Maggio',$string);
	$string = preg_replace('/(June)/', 'Giugno',$string);
	$string = preg_replace('/(July)/', 'Luglio',$string);
	$string = preg_replace('/(August)/', 'Agosto',$string);
	$string = preg_replace('/(September)/', 'Settembre',$string);
	$string = preg_replace('/(October)/', 'Ottobre',$string);
	$string = preg_replace('/(November)/', 'Novembre',$string);
	$string = preg_replace('/(December)/', 'Dicembre',$string);
	
	return $string;
}

function checkTime($thetime)
{
	$timecheck = explode(":", filter_var($thetime, FILTER_SANITIZE_URL));
	
	if (count($timecheck) < 2) return false;
	
	$hourvalid = $minvalid = false;
	if (count($timecheck) > 1 && count($timecheck) < 4) {
	$hourvalid = ((abs(filter_var($timecheck[0], FILTER_SANITIZE_NUMBER_INT)) < 24) 
					&& (abs(filter_var($timecheck[0], FILTER_SANITIZE_NUMBER_INT)) === (INT) $timecheck[0]))
					? true : false;
		$minvalid = ((abs(filter_var($timecheck[1], FILTER_SANITIZE_NUMBER_INT)) < 60) 
					&& (abs(filter_var($timecheck[1], FILTER_SANITIZE_NUMBER_INT)) === (INT) $timecheck[1])) 
					? true : false;
	}
	
	if ($hourvalid && $minvalid) return true;
	
	return false;
}

function getActive($tm, $section)
{
	return isset($tm[$section]) ? $tm[$section] : null;
}

//get the text in the right language
function t($string, $edit = true, $function = "none")
{
	if (isset(Lang::$i18n[Lang::$current][$string]))
	{
// 		if (strcmp(User::$ruolo,"Admin") === 0 and $edit and Lang::$edit)
// 		{
// 			$t = new TraduzioniModel();
// 			
// 			return $t->getTraduzione($string, $function);
// 		}
// 		else
// 		{
			return call_user_func($function,Lang::$i18n[Lang::$current][$string]);
// 			return Lang::$i18n[$tempLang][$string];
// 		}
	}
	else
	{
		$t = new TraduzioniModel();
		
		//inserisco la traduzione
		$t->values = array(
			"chiave"	=>	sanitizeDb($string),
			"valore"	=>	sanitizeDb($string),
			"lingua"	=>	sanitizeDb(Lang::$current),
		);
		$t->insert();
		
		return call_user_func($function,$string);
	}
}

function pulisciData($valore)
{
	$valore = reverseDataSlash($valore);
	
	return sanitizeAll($valore);
}

function pulisciDataDeep($value) {
	return array_map('pulisciData', $value);
}

function dataOra($stringaDataOra)
{
	$dataOra = DateTime::createFromFormat("Y-m-d H:i:s", $stringaDataOra);
	return $dataOra->format("d/m/Y H:i");
}

function convertiData($date = "") {
	$date = new DateTime($date);
	if (strcmp(Lang::$current,'it') == 0) {
		
		return $date->format('d-m-Y H:i:s');
		//$date = $data[2]."/".$data[1]."/".$data[0];
	} else {
		return $date->format('Y-m-d H:i:s');
	}
	
}

function convertiData2($date = "") {
	$date = new DateTime($date);
	if (strcmp(Lang::$current,'it') == 0) {
		
		return $date->format('d-m-Y');
		//$date = $data[2]."/".$data[1]."/".$data[0];
	} else {
		return $date->format('Y-m-d');
	}
	
}

function formattaMinuti($data){

	$now = new DateTime();
	$old_date = new DateTime($data);

	$diff = $now->diff($old_date);	

	$months = $diff->format('%m%');

	if(intval($months) > 0 && intval($months) == 1)
		return $months." ".t("month")." ".t("fa");
	elseif(intval($months) > 1)
		return $months." ".t("months")." ".t("fa");


	$days = $diff->format('%d%');

	if(intval($days) > 0 && intval($days) < 31)
		return $days."g ".t("fa");

	$hours = $diff->format('%h%');

	if(intval($hours) > 0 && intval($hours) < 24)
		return $hours."h ".t("fa");

	$minutes = $diff->format('%i%');
	
	if(intval($minutes) > 0 && intval($minutes) < 60)
		return $minutes."m ".t("fa");
	
	// $seconds = $diff->format('%s%');

	return t("ora");
}

function eq($a,$b){
	return strcmp($a,$b) === 0;
}

function sanitizeTipoAgenda($tipo)
{
	$allowed = array(
		"month","agendaWeek","agendaDay"
	);
	
	if (in_array($tipo, $allowed))
	{
		return sanitizeAll($tipo);
	}
	
	return "agendaWeek";
}

function dateToFormat($date, $format="d/m/Y"){
	
	return date($format,strtotime($date));
}

function pdfDecode($stringa)
{
	return nl2br(strip_tags(br2nl(htmlentitydecode($stringa))));
}

function sha256($string)
{
	return hash("sha256",$string,false);
}

function sha256Deep($value) {
	return array_map('sha256', $value);
}

function rimuoviEntita($array)
{
	$temp = array();
	
	foreach ($array as $val)
	{
		$temp[] = htmlentitydecodeDeep($val);
	}
	
	return $temp;
}

function tagliaStringa($stringa, $max_char=140, $aggiungi=""){
		
	if( strlen($stringa) > $max_char){
		
		$stringa_tagliata = substr($stringa, 0, $max_char);
		$last_space = strrpos($stringa_tagliata, " ");
		$stringa_ok = substr($stringa_tagliata, 0, $last_space);
		return $stringa_ok.$aggiungi;
		
	}else{
		
		return $stringa;
		
	}
}

/*function sanitizeHtml($stringa) {
	
// 	echo mb_detect_encoding($stringa);
	$stringa=htmlentities(utf8encode($stringa),ENT_QUOTES,"UTF-8");
	
	return $stringa;
	
}

function sanitizeHtmlDeep($stringa){
	return array_map('sanitizeHtml', $stringa);
}*/

function utf8encode($stringa)
{
	return strcmp(mb_detect_encoding($stringa),"UTF-8") !== 0 ? utf8_encode($stringa) : $stringa;
}

/**
* @brief controlla che i campi $campi dell'arra $array non siano tutti BLANK
* 
* @param array $array da controllare
* @param string $campi campi da controllare divisi da virgola
*
* @return bool 
*/
function nonTuttiVuoti($array, $campi)
{
	$campiArray = explode(",",$campi);
	
	foreach ($campiArray as $c)
	{
		if (isset($array[$c]) and strcmp($array[$c],"") !== 0) return true;
	}
	
	return false;
}

/**
 * Function to create and display error and success messages
 * @access public
 * @param string session name
 * @param string message
 * @param string display class
 * @return string message
 */
function flash( $name = '', $message = '', $class = 'success fadeout-message' )
{
// 	print_r($_SESSION);
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$name.'_class'] ) )
            {
                unset( $_SESSION[$name.'_class'] );
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            $notice = $_SESSION[$name];
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
            return $notice;
        }
    }
}

function controllaPIVA($variabile){

	if($variabile=='')
		return false;

	//la p.iva deve essere lunga 11 caratteri
	if(strlen($variabile)!=11)
		return false;

	//la p.iva deve avere solo cifre
	if(!preg_match("/^[0-9]+$/", $variabile))
		return false;

	$primo=0;
	for($i=0; $i<=9; $i+=2)
			$primo+= ord($variabile[$i])-ord('0');

	for($i=1; $i<=9; $i+=2 ){
		$secondo=2*( ord($variabile[$i])-ord('0') );

		if($secondo>9)
			$secondo=$secondo-9;
		$primo+=$secondo;

	}
	if( (10-$primo%10)%10 != ord($variabile[10])-ord('0') )
		return false;

	return true;

}

function codiceFiscale($cf){
	if($cf=='')
		return false;

	if(strlen($cf)!= 16)
		return false;

	$cf=strtoupper($cf);
	if(!preg_match("/[A-Z0-9]+$/", $cf))
		return false;
	$s = 0;
	for($i=1; $i<=13; $i+=2){
		$c=$cf[$i];
		if('0'<=$c and $c<='9')
			$s+=ord($c)-ord('0');
		else
			$s+=ord($c)-ord('A');
	}

	for($i=0; $i<=14; $i+=2){
		$c=$cf[$i];
		switch($c){
			case '0':  $s += 1;  break;
			case '1':  $s += 0;  break;
			case '2':  $s += 5;  break;
			case '3':  $s += 7;  break;
			case '4':  $s += 9;  break;
			case '5':  $s += 13;  break;
			case '6':  $s += 15;  break;
			case '7':  $s += 17;  break;
			case '8':  $s += 19;  break;
			case '9':  $s += 21;  break;
			case 'A':  $s += 1;  break;
			case 'B':  $s += 0;  break;
			case 'C':  $s += 5;  break;
			case 'D':  $s += 7;  break;
			case 'E':  $s += 9;  break;
			case 'F':  $s += 13;  break;
			case 'G':  $s += 15;  break;
			case 'H':  $s += 17;  break;
			case 'I':  $s += 19;  break;
			case 'J':  $s += 21;  break;
			case 'K':  $s += 2;  break;
			case 'L':  $s += 4;  break;
			case 'M':  $s += 18;  break;
			case 'N':  $s += 20;  break;
			case 'O':  $s += 11;  break;
			case 'P':  $s += 3;  break;
			case 'Q':  $s += 6;  break;
			case 'R':  $s += 8;  break;
			case 'S':  $s += 12;  break;
			case 'T':  $s += 14;  break;
			case 'U':  $s += 16;  break;
			case 'V':  $s += 10;  break;
			case 'W':  $s += 22;  break;
			case 'X':  $s += 25;  break;
			case 'Y':  $s += 24;  break;
			case 'Z':  $s += 23;  break;
		}
	}

	if( chr($s%26+ord('A'))!=$cf[15] )
		return false;

	return true;
}

function timeDueCifre($string)
{
	$array = explode(":",$string);
	
	return $array[0].":".$array[1];
}

function notificheDaLeggere()
{
	$r = new RevisioniModel();
	
	return $r->daleggere();
}

function numeroNotificheDaLeggere()
{
	$r = new RevisioniModel();
	
	return $r->daleggere(true);
}

function setPrice($price)
{
	$price = str_replace(",",".",$price);
	return $price;
}

function setPriceReverse($price)
{
	$price = number_format((float)$price,2,".","");
	return str_replace(".",",",$price);
}

function getIsoDate($date)
{
	$date = trim($date);
	
	$dateObj = null;

	if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/',$date))
	{
		return $date;
	}
	else if (preg_match('/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/',$date))
	{
		$dateObj = DateTime::createFromFormat("d-m-Y", $date);
	}
	else if (preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/',$date))
	{
		$dateObj = DateTime::createFromFormat("d/m/Y", $date);
	}
	else if (preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}$/',$date))
	{
		$dateObj = DateTime::createFromFormat("d_m_Y", $date);
	}

	if ($dateObj)
		return $dateObj->format("Y-m-d");

	return $date;
}
