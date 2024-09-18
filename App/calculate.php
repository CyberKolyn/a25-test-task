<?php
namespace App;
use App\Application\CalculateService;
use App\Domain\Products\ProductRepository;
use App\Presentation\CalculatePresenter;
use App\Presentation\IPresenter;

require_once 'Domain/Products/ProductRepository.php';
require_once 'Presentation/CalculatePresenter.php';
require_once 'Presentation/IPresenter.php';
require_once 'Application/CalculateService.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new Calculate();
    $instance->calculate($_POST);
}

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
        $days = $this->getDays($request['startDate'] ?? 0, $request['endDate'] ?? 0);
        $product_id = $request['product'] ?? 0;
        $selected_services = $request['services'] ?? [];

        $product = $this->productRepository->findProductById($product_id);

        if (!$product) {
            $this->calculatePresenter
                ->setError('Ошибка, товар не найден!')
                ->present();
            return;
        }

        $calculate_instance = new CalculateService($product, (int) $days, $selected_services);

        $this->calculatePresenter
            ->setTotalSum($calculate_instance->calculate())
            ->setInfo($days, $calculate_instance->findTarif(), $calculate_instance->sum_price_selected_services())
            ->present();
    }

    private function getDays($startDate, $endDate): int
    {
        $startDate = strtotime(trim($startDate));
        $endDate = strtotime(trim($endDate));

        if (!$startDate || !$endDate) {
            $this->calculatePresenter
                ->setError('Ошибка, неправильный формат даты!')
                ->present();
            http_response_code(400);
            exit;
        }

        $startDate = date_create('@'.$startDate);
        $endDate = date_create('@'.$endDate);

        if ($startDate > $endDate) {
            $this->calculatePresenter
                ->setError('Начальная дата проката больше конечной даты!')
                ->present();
            http_response_code(400);
            exit;
        }

        $interval = date_diff($startDate, $endDate);

        return $interval->days + 1;
    }
}
