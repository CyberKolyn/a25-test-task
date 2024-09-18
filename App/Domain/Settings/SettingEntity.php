<?php

namespace App\Domain\Settings;

class SettingEntity
{
    private int $id;

    private string $key;

    private ?string $value;

    public function __construct(array $setting)
    {
        $this->id = $setting['ID'];
        $this->key = $setting['set_key'];
        $this->value = $setting['set_value'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): ?array
    {
        return $this->value ? unserialize($this->value) : [];
    }

}