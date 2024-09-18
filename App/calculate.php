<?php
namespace App;
use App\Application\CalculateService;
use App\Domain\Products\ProductRepository;
use App\Presentation\Products\CalculatePresenter;
use App\Presentation\IPresenter;

require_once 'Domain/Products/ProductRepository.php';
require_once 'Presentation/Products/CalculatePresenter.php';
require_once 'Presentation/IPresenter.php';
require_once 'Application/CalculateService.php';

class Calculate
{
    private ProductRepository $productRepository;

    private IPresenter $calculatePresenter;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->calculatePresenter = new CalculatePresenter();
    }

    public function calculate($request)
    {

        $days = $request['days'] ?? 0;
        $product_id = $request['product'] ?? 0;
        $selected_services = $request['services'] ?? [];

        $product = $this->productRepository->find_product_by_id($product_id);

        if (!$product) {
            $this->calculatePresenter
                ->set_error('Ошибка, товар не найден!')
                ->present();
            return;
        }

        $calculate_instance = new CalculateService($product, (int) $days, $selected_services);

        $this->calculatePresenter
            ->set_total_sum($calculate_instance->calculate())
            ->set_info($days, $calculate_instance->find_tarif(), $calculate_instance->sum_price_selected_services())
            ->present();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new Calculate();
    $instance->calculate($_POST);
}
