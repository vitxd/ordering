<?php

namespace Ordering\Service;

use Silex\Application;
use Ordering\Model\Product;

/**
 * Class ShoppingCartService
 *
 * @package Ordering\Service
 */
class ShoppingCartService
{
    /**
     * @var Application
     */
    private $app;

    /**
     * __construct
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Process product action
     *
     * @param int $productId
     * @param string $action
     * @return array
     * @throws \Exception
     */
    public function processProductAction($productId, $action)
    {
        $response = [
            'status' => false,
            'message' => null
        ];

        /* @var $productRepository \Ordering\Repository\ProductRepository */
        $productRepository = $this->getRepository('products');
        $product           = $productRepository->findById($productId);

        if (empty($product)) {
            $response['message'] = 'Invalid product id.';
        } else {
            /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
            $session      = $this->app['session'];
            $shoppingCart = (is_array($session->get('shopping_cart')) ? $session->get('shopping_cart') : []);

            try {
                $function = sprintf('updateShoppingCart%1$s', ucfirst($action));
                $response = $this->$function($shoppingCart, $product);
            } catch (\Exception $e) {
                // log this...
            }

            $session->set('shopping_cart', $shoppingCart);
        }

        return $response;
    }

    /**
     * Update shopping cart: add
     *
     * @param array $shoppingCart
     * @param Product $product
     * @return array
     */
    protected function updateShoppingCartAdd(&$shoppingCart, Product $product)
    {
        if (!array_key_exists($product->getId(), $shoppingCart)) {
            $shoppingCart[$product->getId()] = 0;
        }
        $shoppingCart[$product->getId()]++;

        return [
            'status'  => true,
            'message' => sprintf('The product \'%1$s\' has been added to your shopping cart.', $product->getName())
        ];
    }

    /**
     * Update shopping cart: remove
     *
     * @param array $shoppingCart
     * @param Product $product
     * @return array
     */
    protected function updateShoppingCartRemove(&$shoppingCart, Product $product)
    {
        if (array_key_exists($product->getId(), $shoppingCart)) {
            unset($shoppingCart[$product->getId()]);
        }

        return [
            'status'  => true,
            'message' => sprintf('The product \'%1$s\' has been removed from your shopping cart.', $product->getName())
        ];
    }

    /**
     * Get repository
     *
     * @param string $repositoryName
     * @return object
     * @throws \Exception
     */
    private function getRepository($repositoryName)
    {
        if($this->app[sprintf('repository.%1$s', $repositoryName)] === null) {
            throw new \Exception(sprintf('Repository %1$s does not exist.', $repositoryName));
        }

        return $this->app[sprintf('repository.%1$s', $repositoryName)];
    }
}
