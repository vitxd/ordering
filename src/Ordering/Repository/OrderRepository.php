<?php

namespace Ordering\Repository;

use Ordering\Model\Order;

/**
 * Class OrderRepository
 *
 * @package Ordering\Repository
 */
class OrderRepository extends Base
{
    /**
     * @var string
     */
    private $tableName = 'orders';

    /**
     * Save
     *
     * This method will save / update an order (based on id) and also return the object.
     *
     * @param Order $order
     * @return Order
     */
    public function save(Order $order)
    {
        $data = [
            'customer_id' => $order->getCustomerId(),
            'total'       => $order->getTotal()
        ];

        if ($order->getId() !== null) {
            $this->db->update($this->tableName, $data, ['id' => $order->getId()]);
        } else {
            $data['c_date'] = date('Y-m-d H:i:s');
            $this->db->insert($this->tableName, $data);
            $order
                ->setId($this->db->lastInsertId())
                ->setCDate($data['c_date']);
        }

        return $order;
    }

    /**
     * Build model
     *
     * This method will create a 'Order' instance with the array data.
     *
     * @param array $data
     * @return Order
     */
    protected function buildModel(array $data)
    {
        return (new Order())
            ->setId($data['id'])
            ->setCustomerId($data['customer_id'])
            ->setTotal($data['total'])
            ->setCDate($data['c_date']);
    }
}
