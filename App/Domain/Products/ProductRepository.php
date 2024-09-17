<?php

namespace App\Domain\Products;

use sdbh\sdbh;

require_once __DIR__ . '/../../Infrastructure/sdbh.php';
require_once __DIR__ . '/ProductEntity.php';

class ProductRepository
{
    private Sdbh $dbh;

    public function __construct()
    {
        $this->dbh = new Sdbh();
    }

    public function find_product_by_id($productId) : ?ProductEntity
    {
        $array = $this->dbh->make_query("SELECT * FROM a25_products WHERE (ID = $productId) LIMIT 1");

        if (!$array) {
            return null;
        }

        return (new ProductEntity(array_shift($array)));
    }
}