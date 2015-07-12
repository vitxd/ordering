<?php

namespace Ordering\Controller;

use Ordering\Model\Order;
use Ordering\Model\OrderProduct;
use Ordering\Model\User;

/**
 * Class OrderController
 *
 * @package Ordering\Controller
 */
class OrderController extends Base
{
    /**
     * Index - action
     *
     * @return mixed
     */
    public function indexAction()
    {
        /* @var $productRepository \Ordering\Repository\ProductRepository */
        $productRepository = $this->getRepository('products');
        $products          = $productRepository->findByLimitAndOffset(10, 0);
        // 10 product should be enough for this demo :)

        $this->view->add('actionsUrl', '/order/action/');
        $this->view->add('products', $products);

        return $this->view->render();
    }

    /**
     * Check out - action
     *
     * @return mixed
     */
    public function checkOutAction()
    {
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session      = $this->app['session'];
        $shoppingCart = (is_array($session->get('shopping_cart')) ? $session->get('shopping_cart') : []);
        $productIds   = array_keys($shoppingCart);

        /* @var $productRepository \Ordering\Repository\ProductRepository */
        $productRepository = $this->getRepository('products');
        $products          = $productRepository->findByIds($productIds);

        /* @var $user \Ordering\Model\User */
        $user = $this->app['security']->getToken()->getUser();

        if ($this->getRequest()->isMethod('POST') && ($user instanceof User)) {
            $orderTotal = 0;

            /* @var $product \Ordering\Model\Product */
            foreach ($products as $product) {
                $orderTotal += $shoppingCart[$product->getId()] * $product->getCost();
            }

            /* @var $orderRepository \Ordering\Repository\OrderRepository */
            $orderRepository = $this->getRepository('orders');
            $order           = $orderRepository->save(
                (new Order())
                    ->setCustomerId($user->getId())
                    ->setTotal($orderTotal)
            );

            /* @var $orderProductRepository \Ordering\Repository\OrderProductRepository */
            $orderProductRepository = $this->getRepository('orderProducts');
            foreach ($products as $product) {
                $orderProductRepository->save(
                    (new OrderProduct())
                        ->setOrderId($order->getId())
                        ->setProductId($product->getId())
                        ->setProductName($product->getName())
                        ->setProductCost($product->getCost())
                        ->setQuantity($shoppingCart[$product->getId()])
                );
            }

            $session->remove('shopping_cart');
            $session->getFlashBag()->add(
                'success',
                sprintf('The order with the id #%1$s has been sent!', $order->getId())
            );

            return $this->app->redirect('/order/checkout');
        }

        $this->view->add('is_logged', ($user instanceof User));
        $this->view->add('actionsUrl', '/order/action/');
        $this->view->add('shoppingCart', $shoppingCart);
        $this->view->add('products', $products);

        return $this->view->render();
    }
}
