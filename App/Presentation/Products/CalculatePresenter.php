<?php

namespace App\Presentation\Products;

use App\Presentation\IPresenter;
require __DIR__ . '/../IPresenter.php';
class CalculatePresenter implements IPresenter
{

    private ?float $total_sum;

    private ?string $info;

    private ?string $error;

    public function set_total_sum(float $total_sum) : IPresenter
    {
        $this->total_sum = $total_sum;
        return $this;
    }

    public function set_days(int $days) : IPresenter
    {
        $this->days = $days;
        return $this;
    }

    public function set_tarif(string $error) : IPresenter
    {
        $this->error = $error;
        return $this;
    }

    public function set_services(float $services) : IPresenter
    {
        $this->services = $services;
        return $this;
    }

    public function set_error(string $error) : IPresenter
    {
        $this->error = $error;
        return $this;
    }

    public function set_info(int $days = 0, float $tarif = 0, float $services = 0) : IPresenter
    {
        $this->info = "Выбрано $days дней Тариф: $tarif р./сутки + $services р/сутки за доп.услуги";
        return $this;
    }


    public function present()
    {
        if (isset($this->error)) {
            echo json_encode(['error' => $this->error]);;
            return;
        }

        echo json_encode([
            'total_sum' => $this->total_sum ?? 0,
            'calculation_info' => $this->info ?? "Нет данных",
        ]);
    }
}