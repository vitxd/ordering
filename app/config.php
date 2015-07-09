<?php

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'ordering',
    'user'     => 'ordering',
    'password' => 'ordering',
);


$app['cache.path'] = '/tmp/twig/cache';
$app['log_level'] = 'debug';
