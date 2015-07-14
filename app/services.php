<?php

use Silex\Application;

$app['service.shoppingCart'] = $app->share(function(Application $app){
    return new Ordering\Service\ShoppingCartService($app);
});
