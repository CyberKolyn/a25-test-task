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

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTarifs(): array
    {
        return $this->tarifs ? unserialize($this->tarifs) : [];
    }
}