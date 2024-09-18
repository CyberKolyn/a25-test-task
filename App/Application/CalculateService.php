<?php

namespace App\Application;

use App\Domain\Products\ProductEntity;

class CalculateService
{
    private ProductEntity $product;

    private int $days;

    private array $selectedServices;

    public function __construct(ProductEntity $product, int $days, array $selected_services)
    {
        $this->product = $product;
        $this->days = $days;
        $this->selectedServices = $selected_services;
    }

    public function calculate() : float
    {
        return $this->calculatePrice() + $this->calculateService();
    }

    public function calculatePrice() : float
    {
        $price = $this->product->getPrice();

        if (count($this->product->getTarifs()) > 0) {
            $price = $this->findTarif();
        }

        return $price * $this->days;
    }

    public function calculateService() : float
    {
        return $this->sum_price_selected_services() * $this->days;
    }

    public function sum_price_selected_services() : float
    {
        return array_sum($this->selectedServices);
    }

    public function findTarif() : int
    {
        $tarifs = $this->product->getTarifs();

        ksort($tarifs);

        $tarifs = array_filter($tarifs, function ($price, $day_count) {
            return $this->days >= $day_count;
        }, ARRAY_FILTER_USE_BOTH);

        return (end($tarifs));
    }


}