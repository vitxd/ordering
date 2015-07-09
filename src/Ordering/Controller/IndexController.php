<?php
/**
 * Created by PhpStorm.
 * User: vitxd
 * Date: 09/07/15
 * Time: 10:29
 */

namespace Ordering\Controller;


class IndexController extends Base
{
	public function indexAction()
	{
		$this->view->error 			= $this->app['security.last_error']($this->getRequest());
		$this->view->last_username 	= $this->app['session']->get('_security.last_username');

		if ($this->app['security.authorization_checker']->isGranted('ROLE_LOGGED_IN'))
		{
			return $this->app->redirect('/me');
		}
		return $this->view->render();
	}
}