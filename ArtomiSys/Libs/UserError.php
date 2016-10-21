<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\Log;

Class UserError extends \Exception
{
	protected $message;
	protected $code = 0;
	protected $useLog = false;
	protected $whitelist = ["404"];

	protected $errorFile;

	public function __construct($message, $code = 0, $useLog = false)
	{
		$this->message = $message;
		$this->code = $code;
		$this->useLog = $useLog;

		$this->setError();
	}

	public function show()
	{
		// write to error log
		if ($this->useLog) {
			$this->writeLog($this->message, $this->code);
		}

		require_once($this->errorFile);
		die();
	}

	protected function setError()
	{
		switch($this->code) {
			case 404:
				// Not found
				http_response_code(404);
				$this->message = "Sivua ei löytynyt!";
				$this->errorFile = PATH_FILE_ROOT ."/". PATH_TO_ERROR_FILES ."/404.phtml";
				break;
			default:
				// Unknown error (internal server error)
				http_response_code(500);
				$this->errorFile = PATH_FILE_ROOT ."/". PATH_TO_ERROR_FILES ."/500.phtml";
				break;
		}

		if (APP_ENV !== 'development' && !in_array($this->code, $this->whitelist))
			$this->handleProductionErrors();
	}

	// if not in development
	protected function handleProductionErrors()
	{
		// first, log the real error
		$this->writeLog($this->message, $this->code);

		// show a general error page
		http_response_code(503);
		$this->message = "<p>Palvelimella on huoltokatko. Yritä uudelleen hetken kuluttua.</p><p>Jos ongelma jatkuu, ota yhteyttä tukeen.</p>";
		$this->errorFile = PATH_FILE_ROOT ."/". PATH_TO_ERROR_FILES ."/503.phtml";
		$this->useLog = false;

		return true;
	}

	protected function writeLog($message, $code)
	{
		return Log::write($message. "(". $code .")", 'ERROR');
	}
}