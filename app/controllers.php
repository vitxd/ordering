<?php

use Silex\Application;

$app['home.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\HomeController($app);
});
$app['index.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\IndexController($app);
});
$app['user.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\UserController($app);
});
$app['order.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\OrderController($app);
});