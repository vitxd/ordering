<?php

$app['controllers']->convert('page', function($page){
	$tmp = join('', array_map(function($a){return ucfirst(strtolower($a));}, explode('-', $page)));
	$tmp[0] = strtolower($tmp[0]);
	return $tmp;
});

$app->match('/me', 'home.controller:route');

$app->match('/{page}', 'login.controller:route')
	->assert('page', 'login|sign-up')
;
$app->match('/login', 'login.controller:loginAction');

$app
	->match('/{page}', 'index.controller:route')
	->value('page', 'index');

