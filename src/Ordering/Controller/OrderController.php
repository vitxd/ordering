<?php

namespace Ordering\Controller;


class OrderController extends Base
{
	public function indexAction()
	{
		// Load products


		return $this->view->render();
	}

	public function checkOutAction()
	{
		// create order

		return $this->view->render();
	}
}