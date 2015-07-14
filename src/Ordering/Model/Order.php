<?php

namespace Ordering\Model;

/**
 * Class Order
 *
 * @package Ordering\Model
 */
class Order
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $customer_id;

    /**
     * @var float
     */
    protected $total;

    /**
     * @var \DateTime
     */
    protected $c_date;


    /**
     * Set id
     *
     * @param int $id
     * @return Order
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
     * Set customer id
     *
     * @param int $customerId
     * @return Order
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set creation date
     *
     * @param string $cDate
     * @return Order
     */
    public function setCDate($cDate)
    {
        $this->c_date = new \DateTime($cDate);

        return $this;
    }

    /**
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCDate()
    {
        return $this->c_date;
    }
}
