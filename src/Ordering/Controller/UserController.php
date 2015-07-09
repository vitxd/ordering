<?php

namespace Ordering\Controller;


use Ordering\Model\User;

class UserController extends Base
{
	public function signUpAction()
	{
		$this->view->error = '';
		if ($this->getRequest()->isMethod('POST'))
		{
			$data = $this->getRequest()->request->get('user', null);

			if (is_array($data))
			{
				if ($data['password1'] == $data['password2'])
				{

					$user = new User;
					$user
						->setEmail($data['email'])
						->setFirstname($data['firstname'])
						->setSurname($data['surname'])
						->setPassword($data['password1']);

					$this->getRepository('users')->save($user);

					return $this->app->redirect('/user/login');
				}
				else
				{
					$this->view->error = 'Two passwords must match';
				}
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