<?php

// All EasyGiant code is released under the GNU General Public License or a compatible license.
// See COPYRIGHT.txt and LICENSE.txt.

class LogController extends Controller {

	public function index()
	{
		Files_Log::$logFolder = ROOT.'/Logs';
		Files_Log::$logExtension = '.txt';
		Files_Log::$logPermission = 0777;
		
		$logFile = Files_Log::getInstance('ciao');
		$logFile->writeString("URI:\t".$_SERVER['REQUEST_URI']);

		Files_Log::$logFolder = ROOT.'/Logs/';
		Files_Log::$logExtension = '.log';
		Files_Log::$logPermission = 0777;
		
		$logFile = Files_Log::getInstance('ciao2');
		$logFile->writeString("cazzone");

// 		logFile::$logFolder = ROOT.'/logs/';
// 		logFile::$logExtension = '.log';
// 		logFile::$logPermission = 0777;
// 		
// 		$logFile = logFile::getInstance('errors');
// 		$logFile->clearBefore(3);
		
// 		$a= clone $logFile;
// 		$file->clearBefore(5);
// 		echo '<pre>';
// 		print_r($lines);
// 		echo '</pre>';
// 		echo $file->getDateString('[[2010-01-08 00:09:54]]	ciao');
// 		$ff = new SplFileObject(ROOT.'/logs/test.log','a+');
// 		
// 		$ff->ftruncate(0);
// 
// 		foreach ($ff as $item)
// 		{
// 			echo $item."<br />";
// 		}
// 		
		echo '<br />ciao';
	}

}