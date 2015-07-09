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
		return $this->view->render();
	}
}