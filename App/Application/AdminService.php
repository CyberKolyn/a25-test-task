<?php
namespace App\Application;
require_once __DIR__.'/../Domain/Users/UserEntity.php'; use App\Domain\Users\UserEntity;
require_once __DIR__.'/../Domain/DB.php'; use App\Domain\DB;

class AdminService {

    /** @var UserEntity */
    public $user;

    public function __construct()
    {
        $this->user = new UserEntity();
    }

    public function addNewProduct()
    {
        if (!$this->user->isAdmin) return;
    }

    public function createProduct($request)
    {
        $payload = [
            [
                'NAME' => $request['name'],
                'PRICE' => $request['price'],
                'TARIFF' => $this->createSerializedTarifs($request['tarifsDay'] ?? [], $request['tarifsPrice'] ?? []),
            ]
        ];

        DB::getInstance()->create('a25_products', $payload);
    }

    private function createSerializedTarifs(array $days, array $prices) : ?string
    {
        $tarifs = [];

        if (count($days) > 0 && count($days)) {
            foreach ($days as $index => $day) {
                $tarifs[$day] = (int) $prices[$index];
            }

            ksort($tarifs);
        }

        return count($tarifs) > 0 ? serialize($tarifs) : null;
    }
}
