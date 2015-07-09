<?php

namespace Ordering\Misc;

use Silex\Application;

class View
{
	protected $twig;

	protected $filename;
	protected $variables = array();
	protected $directory;


	protected $template;

	/**
	 * @param Application|array $app
	 */
	public function __construct(Application $app)
	{
		$this->twig = $app['twig'];
	}

	/**
	 * @param string $filename
	 * @return View
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * @param string $key
	 * @param mixed $val
	 * @return View
	 */
	public function add($key, $val) {
		$this->variables[$key] = $val;
		return $this;
	}

	/**
	 * @param string $key
	 * @param mixed $val
	 */
	public function __set($key, $val) {
		$this->add($key, $val);
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key) {
		return  array_key_exists($key, $this->variables)
				? $this->variables[$key]
				: null;
	}

	/**
	 * @param null $dir
	 * @param null $file
	 * @return mixed
	 */
	public function render($file = null, $dir = null) {
		if($dir !== null)  $this->setDirectory($dir);
		if($file !== null) $this->setFilename($file);

		return $this->twig->render($this->getFilePath(), $this->variables);
	}

	public function getFilePath()
	{
		return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getFilename();
	}

	/**
	 * @param string $directory
	 * @return View
	 */
	public function setDirectory($directory) {
		$this->directory = $directory;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDirectory() {
		return $this->directory;
	}
}
