<?php

namespace Ordering\Controller;


use Ordering\Model\User;

class HomeController extends Base
{
	public function meAction()
	{
		$user 					= $this->app['security']->getToken()->getUser();
		$this->view->user 		= $user;
		$this->view->is_logged 	= ($user instanceof User);

		return $this->view->render('me.twig');
	}
}