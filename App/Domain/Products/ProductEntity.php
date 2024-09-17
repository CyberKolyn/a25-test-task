<?php

namespace App\Domain\Products;

class ProductEntity
{
    const table_name = "a25_products";
    private int $id;

    private string $name;

    private float $price;

    private ?string $tarifs;

    public function __construct(array $product)
    {
        $this->id = $product["ID"];
        $this->name = $product["NAME"];
        $this->price = $product["PRICE"];
        $this->tarifs = $product["TARIFF"];
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_price(): float
    {
        return $this->price;
    }

    public function get_tarifs(): array
    {
        return $this->tarifs ? unserialize($this->tarifs) : [];
    }
}