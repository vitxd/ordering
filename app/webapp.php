<?php

use Ordering\Misc\View;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

$app = require __DIR__ . '/common.php';


$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// Twig cache
$app['twig.options.cache'] = $app['cache.path'];

$app['session.storage.options'] = [
	'cookie_lifetime' 	=> 0
];

$app->register(new Silex\Provider\SessionServiceProvider(), array(
	'session.storage.options' => $app['session.storage.options']
));

$app['session.db_options'] = array(
	'db_table'      => 'sessions',
	'db_id_col'     => 'hash',
	'db_data_col'   => 'data',
	'db_time_col'   => 'time',
);

$app['session.storage.handler'] = $app->share(function () use ($app) {
	return new PdoSessionHandler(
		$app['db']->getWrappedConnection(),
		$app['session.db_options']
	);
});

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new UrlGeneratorServiceProvider());
$app['twig.options.cache'] = $app['cache.path'];
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.options' => array(
		'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
		'strict_variables' 	=> true,
		'auto_reload' 		=> true
	),
	'twig.path' => [FRAMEWORK_HOME_DIR . '/../src/views']
));
$app->register(new Silex\Provider\RememberMeServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => [

		'secure' => [
			'anonymous' => true,
			'pattern' => '^/.*$',
			'form' 		=> [
				'login_path' 			=> '/user/login',
				'check_path' 			=> '/me/login_check',
				'username_parameter' 	=> 'user[email]',
				'password_parameter' 	=> 'user[password]',
			],
			'logout' 	=> ['logout_path' => '/user/logout'],
			'users' 	=> $app->share(function () use ($app) {
				return new Ordering\Repository\UserRepository($app);
			}),
		],
//		'login' => [
//			'pattern' => '^/(login)?',
//			'anonymous' => true,
//		],
	],
	'security.access_rules' => array(
		['^/me', 'ROLE_LOGGED_IN'],
	)
//		['path' => '/me$', 	'role' => 'ROLE_LOGGED_IN'],
//		['path' => '/', 	'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'],
//	),
));

$app['view'] = $app->share(function($app) {
	return new View($app);
});



require __DIR__ . '/controllers.php';
require __DIR__ . '/routes.php';

return $app;
