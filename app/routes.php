<?php

$app['controllers']->convert('page', function($page){
	if ($page)
	{
		$tmp = join('', array_map(function($a){return ucfirst(strtolower($a));}, explode('-', $page)));
		$tmp[0] = strtolower($tmp[0]);
		return $tmp;
	}
});

$app->match('/me', 'home.controller:meAction');

$app->match('/user/{page}', 'user.controller:route')
	->assert('page', 'login|sign-up')
;

$app->match('/order/{page}', 'order.controller:route')
	->value('page', 'index');

$app
	->match('/{page}', 'index.controller:route')
	->value('page', 'index');

