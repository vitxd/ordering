<?php
namespace Ordering\Repository;


use Silex\Application;

class Base
{
	/**
	 * @var Application
	 */
	protected $app;

	/**
	 * @var \Doctrine\DBAL\Connection
	 */
	protected $db;
	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->db  = $app['db'];
	}
}