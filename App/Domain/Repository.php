<?php

namespace App\Domain;

require_once 'DB.php'; use App\Domain\DB;

class Repository
{
    protected DB $DB;

    public function __construct()
    {
        $this->DB = DB::getInstance();
    }
}