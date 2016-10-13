<?php

namespace ArtomiSys\Libs;

Class Log
{
	public static function write($str, $type = 'DEFAULT')
	{
		if(strlen($str) <= 0) return false;

		$logFile = PATH_FILE_ROOT ."/". PATH_TO_LOGS . "/";

		// select log by type
		switch ($type) {
			case 'ERROR':
				$logFile .= 'errors.log';
				break;
			
			default:
				$logFile .= 'artomisys.log';
				break;
		}

		$logLine = '['. date('Y-m-d H:i:s').' ';

		// if logged in, log user id
		if (!empty($_SESSION['loggedin'])) {
			$logLine .= ' user: '. $_SESSION['userid'] .' ';
		}

		// log user's ip address
		$logLine .= 'ip:'. $_SERVER['REMOTE_ADDR'] .'] ';
		$logLine .= $str;

		$file = fopen($logFile, 'a');
		fwrite($file, "\n".$logLine);

		return fclose($file);
	}
}