<?php
namespace Ordering\Repository;


use Silex\Application;

abstract class Base
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

    /**
     * Build models
     *
     * This method will create based on the array data multiple 'Object' instances.
     *
     * @param array $data
     * @return array
     */
    protected function buildModels(array $data)
    {
        $objects = [];
        foreach ($data as $key => $value) {
            $objects[$key] = $this->buildModel($value);
        }

        return $objects;
    }

    /**
     * Build model
     *
     * @param array $data
     * @return object
     */
    abstract protected function buildModel(array $data);
}