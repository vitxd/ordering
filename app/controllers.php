<?php

use Silex\Application;

$app['home.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\HomeController($app);
});
$app['index.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\IndexController($app);
});
$app['login.controller'] = $app->share(function(Application $app){
	return new Ordering\Controller\LoginController($app);
});