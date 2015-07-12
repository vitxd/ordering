<?php

namespace Ordering\Controller;

/**
 * Class OrderActionController
 *
 * @package Ordering\Controller
 */
class OrderActionController extends Base
{
    /**
     * Add to cart - action
     *
     * @return mixed
     */
    public function addToCartAction()
    {
        if ($this->getRequest()->isMethod('POST')) {
            $id = $this->getRequest()->request->get('id', null);

            /* @var $shoppingCartService \Ordering\Service\ShoppingCartService */
            $shoppingCartService = $this->getService('shoppingCart');

            $response = $shoppingCartService->processProductAction($id, 'add');

            return json_encode($response);
        }

        return false;
    }

    /**
     * Remove from cart - action
     *
     * @return mixed
     */
    public function removeFromCartAction()
    {
        if ($this->getRequest()->isMethod('POST')) {
            $id = $this->getRequest()->request->get('id', null);

            /* @var $shoppingCartService \Ordering\Service\ShoppingCartService */
            $shoppingCartService = $this->getService('shoppingCart');

            $response = $shoppingCartService->processProductAction($id, 'remove');

            return json_encode($response);
        }

        return false;
    }
}
