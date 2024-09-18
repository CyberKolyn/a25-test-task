<?php

namespace App\Application;

use App\Domain\Products\ProductEntity;

class CalculateService
{
    private ProductEntity $product;

    private int $days;

    private array $selected_services;

    public function __construct(ProductEntity $product, int $days, array $selected_services)
    {
        $this->product = $product;
        $this->days = $days;
        $this->selected_services = $selected_services;
    }

    public function calculate() : float
    {
        return $this->calculate_price() + $this->calculate_service();
    }

    public function calculate_price() : float
    {
        $price = $this->product->get_price();

        if (count($this->product->get_tarifs()) > 0) {
            $price = $this->find_tarif();
        }

        return $price * $this->days;
    }

    public function calculate_service() : float
    {
        return $this->sum_price_selected_services() * $this->days;
    }

    public function sum_price_selected_services() : float
    {
        return array_sum($this->selected_services);
    }

    public function find_tarif() : int
    {
        $tarifs = $this->product->get_tarifs();

        ksort($tarifs);

        $tarifs = array_filter($tarifs, function ($price, $day_count) {
            return $this->days >= $day_count;
        }, ARRAY_FILTER_USE_BOTH);

        return (end($tarifs));
    }


}