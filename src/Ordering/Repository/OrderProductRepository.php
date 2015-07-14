<?php

namespace Ordering\Repository;

use Ordering\Model\OrderProduct;

/**
 * Class OrderProductRepository
 *
 * @package Ordering\Repository
 */
class OrderProductRepository extends Base
{
    /**
     * @var string
     */
    private $tableName = 'order_products';

    /**
     * Save
     *
     * This method will save / update an order product (based on id) and also return the object.
     *
     * @param OrderProduct $orderProduct
     * @return OrderProduct
     */
    public function save(OrderProduct $orderProduct)
    {
        $data = [
            'order_id'     => $orderProduct->getOrderId(),
            'product_id'   => $orderProduct->getProductId(),
            'product_name' => $orderProduct->getProductName(),
            'product_cost' => $orderProduct->getProductCost(),
            'quantity'     => $orderProduct->getQuantity()
        ];

        if ($orderProduct->getId() !== null) {
            $this->db->update($this->tableName, $data, ['id' => $orderProduct->getId()]);
        } else {
            $this->db->insert($this->tableName, $data);
            $orderProduct->setId($this->db->lastInsertId());
        }

        return $orderProduct;
    }

    /**
     * Build model
     *
     * This method will create a 'OrderProduct' instance with the array data.
     *
     * @param array $data
     * @return OrderProduct
     */
    protected function buildModel(array $data)
    {
        return (new OrderProduct())
            ->setId($data['id'])
            ->setOrderId($data['order_id'])
            ->setProductId($data['product_id'])
            ->setProductName($data['product_name'])
            ->setProductCost($data['product_cost'])
            ->setQuantity($data['quantity']);
    }
}
