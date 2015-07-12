<?php

namespace Ordering\Model;

/**
 * Class OrderProduct
 *
 * @package Ordering\Model
 */
class OrderProduct
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $order_id;

    /**
     * @var int
     */
    protected $product_id;

    /**
     * @var string
     */
    protected $product_name;

    /**
     * @var float
     */
    protected $product_cost;

    /**
     * @var int
     */
    protected $quantity;


    /**
     * Set id
     *
     * @param int $id
     * @return OrderProduct
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order id
     *
     * @param int $orderId
     * @return OrderProduct
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get order id
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set product id
     *
     * @param int $productId
     * @return OrderProduct
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;

        return $this;
    }

    /**
     * Get product id
     *
     * @return int
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set product name
     *
     * @param string $productName
     * @return OrderProduct
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;

        return $this;
    }

    /**
     * Get product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set product cost
     *
     * @param float $productCost
     * @return OrderProduct
     */
    public function setProductCost($productCost)
    {
        $this->product_cost = $productCost;

        return $this;
    }

    /**
     * Get product cost
     *
     * @return float
     */
    public function getProductCost()
    {
        return $this->product_cost;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     * @return OrderProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
