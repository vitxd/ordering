<?php

namespace Ordering\Controller;

use Ordering\Misc\View;
use Ordering\Model\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

abstract class Base
{
	/**
	 * @var \Silex\Application
	 */
	protected $app;

	/**
	 * @var array
	 */
	protected $action;
	protected $path_args;

	/**
	 * @var View
	 */
	protected $view;

	/**
	 * @param Application $app
	 */
	public function __construct(Application $app)
	{
		$this->app			= $app;
		$this->view 		= $this->app['view'];
		$class      	    = explode("\\", get_class($this));
		$class_name 		= array_pop($class);
		$this->controller 	= $class_name;
		$this->view->setDirectory(strtolower(substr($this->controller,  0, strpos($this->controller, 'Controller'))));
	}

	/**
	 * Default method to call for routing based on actions defined in the controller
	 * @param $page
	 * @param $args
	 * @return mixed
	 */
	public function route($page, $args = null)
	{
		if (!$args)
		{
			$args = array();
		}
		$action = $page . 'Action';
		$this->action = $action;

		$this->handlePathArgs($args);

		if (!method_exists($this, $action))
		{
			$this->app->abort(404, "Page $page does not exist.");
		}

		$user 					= $this->app['security']->getToken()->getUser();
		$this->view->user 		= $user;
		$this->view->is_logged 	= ($user instanceof User);

		$this->view->setFilename($page . '.twig');
		return $this->{$action}();
	}

	/**
	 * Returns the repository requested
	 *
	 * @param $repository_name
	 * @return mixed
	 * @throws \Exception
	 */
	protected function getRepository($repository_name)
	{
		if($this->app['repository.' . $repository_name] === null)
		{
			throw new \Exception('Repository '. $repository_name . ' does not exist');
		}
		return $this->app['repository.' . $repository_name];
	}
	/**
	 * @return array
	 */
	protected function getFields()
	{
		$fields = $this->getRequest()->query->get('fields', '');

		if(strlen($fields))
		{
			$fields = explode(',', $fields);
		}
		else
		{
			$fields = array();
		}

		return $fields;
	}

	/**
	 * @return Request
	 */
	protected function getRequest()
	{
		return $this->app['request'];
	}

	protected function handlePathArgs($args)
	{
		$this->path_args = $args;
	}

    /**
     * Get service
     *
     * @param string $serviceName
     * @return object
     * @throws \Exception
     */
    protected function getService($serviceName)
    {
        if($this->app[sprintf('service.%1$s', $serviceName)] === null) {
            throw new \Exception(sprintf('Service %1$s does not exist.', $serviceName));
        }

        return $this->app[sprintf('service.%1$s', $serviceName)];
    }
}