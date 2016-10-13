<?php

namespace ArtomiSys\Libs;

class View
{
	public $title;
	public $css;
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

	/**
	* Prints out the final page
	* @param {string} sheet view sheet name without extension (located in views)
	*/
	public function render($sheet)
	{
		// load default css file
		if (empty($this->css)) $this->css = 'main.css';
		$this->css = PATH_TO_CSS .'/'. $this->css;

		// page title
		if (!isset($this->title)) $this->title = APP_NAME;

		// if snippets given by controller, initialize them
		if (!empty($this->snippets)) $this->snippets = $this->initSnippets($this->snippets);

		// get contents of $sheet as a variable using output buffering
		ob_start();
		if ($this->tryit(PATH_FILE_ROOT. '/' . PATH_TO_SHEETS . '/' . $sheet .'.phtml')) {
			$this->output = ob_get_clean();
		} else {
			ob_get_clean();
		}
		
		require($this->templateFile);
	}

	/**
	* Returns all snippets' contents
	* @param {array} snippets array containing snippets ('name' => 'path')
	* @return {array} snippets' contents as strings
	*/
	private function initSnippets(array $snippets)
	{
		$result = array();

		foreach($snippets as $name => $path) {
			ob_start();
			require(PATH_FILE_ROOT . '/' . PATH_TO_SNIPPETS . '/' . $path . '.phtml');
			$result[$name] = ob_get_clean();
		}

		return $result;
	}

	private function templatePath($template)
	{
		return PATH_FILE_ROOT .'/'. PATH_TO_TEMPLATES . '/' . $template . '.phtml';
	}

	/**
	* TODO: DEFINITELY NOT A FINAL METHOD!
	*/
	private function tryit($file)
	{
		if (file_exists($file)) {
			return require($file);
		} else {
			die('<strong>Error!</strong> File not found: \''.$file.'\'');
		}
	}
}
