<?php


namespace App\Contract;


interface ProductContract
{
    /**
     * @param string         $order
     * @param string         $sort
     * @param array|string[] $columns
     * @return mixed
     */
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findProductById(int $id);


    /**
     * @param $slug
     * @return mixed
     */
    public function findProductBySlug($slug);

    /**
     * @param array $params
     * @return mixed
     */
    public function createProduct(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateProduct(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteProduct($id);

}