<?php

require_once 'Application/AdminService.php'; use App\Application\AdminService;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new AdminService();
    $instance->createProduct($_POST);
//    echo var_dump($_POST);
}