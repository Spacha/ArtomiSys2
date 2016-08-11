<?php

namespace ArtomiSys\Libs;

class View
{
	public $title;
	protected $templateFile;

	/*  */
	public function __construct($template = 'default')
	{
		$templateFile = $this->templatePath($template);

		if (!file_exists($templateFile)) {
			throw new \Exception('Missing template file \'' . $templateFile . '\'.');
		}

		$this->templateFile = $templateFile;
	}

	public function render($sheet)
	{
		// page title
		if (!isset($this->title)) $this->title = APP_NAME;

		// if snippets given by controller, initialize them
		if (!empty($this->snippets)) $this->snippets = $this->initSnippets($this->snippets);

		// get contents of $sheet as a variable using output buffering
		ob_start();
		require(PATH_ROOT. '/' . PATH_TO_SHEETS . '/' . $sheet .'.phtml');
		$this->output = ob_get_clean();
		
		require($this->templateFile);
	}

	private function initSnippets(array $snippets)
	{
		$result = array();

		foreach($snippets as $name => $path) {
			ob_start();
			 require(PATH_ROOT . '/' . PATH_TO_SNIPPETS . '/' . $path . '.phtml');
			$result[$name] = ob_get_clean();
		}

		return $result;
	}

	private function templatePath($template)
	{
		return PATH_ROOT .'/'. PATH_TO_TEMPLATES . '/' . $template . '.phtml';
	}
}
