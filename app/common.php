<?php

use Monolog\Handler\ErrorLogHandler;

require_once '../vendor/autoload.php';

define('FRAMEWORK_HOME_DIR', __DIR__);

if(!(isset($app) && ($app instanceof \Silex\Application)))
{
	$app = new Silex\Application();
}

require __DIR__ . '/config.php';

$app->register(new Silex\Provider\MonologServiceProvider(), array(
		'monolog.name' 			=> 'KOBAS',
//		'monolog.logger.class' 	=> 'KOBAS\\util\\Logger',
		'monolog.handler' 		=> new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, $app['log_level']),
		'monolog.level'			=> $app['log_level'],
//	'monolog.listener'		=> new LogListener($app['logger'])
));

$app->register(new Silex\Provider\DoctrineServiceProvider());


require __DIR__ . '/repositories.php';

return $app;
