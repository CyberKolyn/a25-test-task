<?php

namespace App\Presentation;

require 'IPresenter.php';
class CalculatePresenter implements IPresenter
{

    private ?float $totalSum;

    private ?string $info;

    private ?string $error;

    public function setTotalSum(float $totalSum) : IPresenter
    {
        $this->totalSum = $totalSum;
        return $this;
    }

    public function setError(string $error) : IPresenter
    {
        $this->error = $error;
        return $this;
    }

    public function setInfo(int $days = 0, float $tarif = 0, float $services = 0) : IPresenter
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
            'total_sum' => $this->totalSum ?? 0,
            'calculation_info' => $this->info ?? "Нет данных",
        ]);
    }
}