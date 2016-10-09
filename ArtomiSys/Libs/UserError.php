<?php

namespace ArtomiSys\Libs;

use ArtomiSys\Libs\Log;

Class UserError extends \Error
{
	protected $message;
	protected $code = 0;
	protected $useLog = false;

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
			Log::write($this->message. "(". $this->code .")", 'ERROR');
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
				$this->errorFile = PATH_TO_ERROR_FILES ."/404.phtml";
				break;
			default:
				// Unknown error (internal server error)
				http_response_code(500);
				$this->errorFile = PATH_TO_ERROR_FILES ."/500.phtml";
				break;
		}
	}
}