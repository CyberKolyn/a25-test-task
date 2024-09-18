<?php
namespace App\Domain\Settings;

use App\Domain\Repository;

require_once 'SettingEntity.php';
require_once __DIR__ . '/../Repository.php';

use App\Domain\Settings\SettingEntity;

class SettingRepository extends Repository
{
    public function findSettingServices() : ?SettingEntity
    {
        $setting = $this->DB->read('a25_settings', ['set_key' => 'services'], 0, 1, 'id');

        if (!$setting) {
            return null;
        }

        return (new SettingEntity(array_shift($setting)));
    }
}