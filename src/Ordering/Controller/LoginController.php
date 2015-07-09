<?php

namespace Ordering\Controller;


use Ordering\Model\User;

class LoginController extends Base
{
	public function signUpAction()
	{
		if ($this->getRequest()->isMethod('POST'))
		{
			$data = $this->getRequest()->request->get('user', null);

			if (is_array($data))
			{
				$user = new User;
				$user
					->setEmail($data['email'])
					->setName($data['name'])
					->setPassword($data['password']);

				$this->getRepository('users')->save($user);

				return $this->app->redirect('/login');
			}

		}

		return $this->view->render();
	}

	public function loginAction()
	{
		$this->view->error 			= $this->app['security.last_error']($this->getRequest());
        $this->view->last_username 	= $this->app['session']->get('_security.last_username');

		return $this->view->render();
	}
}