<?php

namespace App\Application;

use App\Domain\Products\ProductEntity;

class CalculateService
{
    private ProductEntity $product;

    private int $days;

    private array $selected_services;

    private float $total_value;

    public function __construct(ProductEntity $product, int $days, array $selected_services)
    {
        $this->product = $product;
        $this->days = $days;
        $this->selected_services = $selected_services;
    }

    public function calculate() : float
    {
        $this->calculate_price();
        $this->calculate_service();
        return $this->total_value;
    }

    private function calculate_price() : void
    {
        $price = $this->product->get_price();

        if (count($this->product->get_tarifs()) > 0) {
            $price = $this->find_tarif();
        }

        $this->total_value = $price * $this->days;
    }

    private function calculate_service()
    {
        $services_price = 0;
        foreach ($this->selected_services as $service) {
            $services_price += (float)$service * $this->days;
        }

        $this->total_value += $services_price;
    }

    private function find_tarif() : int
    {
        $tarifs = $this->product->get_tarifs();
        ksort($tarifs);
        $tarifs = array_filter($tarifs, function ($price, $day_count) {
            return $this->days >= $day_count;
        }, ARRAY_FILTER_USE_BOTH);

        return (end($tarifs));
    }


}