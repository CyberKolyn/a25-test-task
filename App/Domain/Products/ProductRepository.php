<?php

namespace App\Domain\Products;

use App\Domain\Repository;

require_once 'ProductEntity.php';
require_once __DIR__ . '/../Repository.php';

class ProductRepository extends Repository
{
    public function productAll(int $limit = 25) : ?array
    {
        $products = $this->DB->rawQuery("SELECT * FROM a25_products LIMIT $limit");

        if (!$products) {
            return null;
        }

        return array_map(
            function (array $product) {
                return new ProductEntity($product);
            },
            $products
        );
    }

    public function findProductById($productId) : ?ProductEntity
    {
        $array = $this->DB->rawQuery("SELECT * FROM a25_products WHERE (ID = $productId) LIMIT 1");

        if (!$array) {
            return null;
        }

        return (new ProductEntity(array_shift($array)));
    }
}