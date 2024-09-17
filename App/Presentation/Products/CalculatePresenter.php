<?php

namespace App\Presentation\Products;

use App\Presentation\IPresenter;
require __DIR__ . '/../IPresenter.php';
class CalculatePresenter implements IPresenter
{

    private string $total_sum;

    private ?string $error;

    public function set_total_sum(float $total_sum) : IPresenter
    {
        $this->total_sum = (string) $total_sum;
        return $this;
    }

    public function set_error(string $error) : IPresenter
    {
        $this->error = $error;
        return $this;
    }


    public function present()
    {
        if (isset($this->error)) {
            echo $this->error;
            return;
        }

        echo $this->total_sum;
    }
}