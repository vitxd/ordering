<?php

use Silex\Application;

$app['repository.users'] = $app->share(function(Application $app){
	return new Ordering\Repository\UserRepository($app);
});
