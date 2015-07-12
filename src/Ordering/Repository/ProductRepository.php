<?php

namespace Ordering\Repository;

use Ordering\Model\Product;

/**
 * Class ProductRepository
 *
 * @package Ordering\Repository
 */
class ProductRepository extends Base
{
    /**
     * @var string
     */
    private $tableName = 'products';

    /**
     * Find by id
     *
     * @param int $id
     * @return Product
     */
    public function findById($id)
    {
        $qB = $this->db->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1);
        $product = $qB->execute()->fetch();

        return $this->buildModel($product);
    }

    /**
     * Find by a list of ids
     *
     * Why 'implode'? it seems setParameter doesn't bind arrays :(.
     *
     * @param array $ids
     * @return array
     */
    public function findByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $qB = $this->db->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->where(sprintf('id IN (%1$s)', implode(', ', $ids)));
        $products = $qB->execute()->fetchAll();

        return $this->buildModels($products);
    }

    /**
     * Find by limit and offset
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findByLimitAndOffset($limit, $offset)
    {
        $qB = $this->db->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        $products = $qB->execute()->fetchAll();

        return $this->buildModels($products);
    }

    /**
     * Build model
     *
     * This method will create a 'Product' instance with the array data.
     *
     * @param array $data
     * @return Product
     */
    protected function buildModel(array $data)
    {
        return (new Product())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setCost($data['cost']);
    }
}
