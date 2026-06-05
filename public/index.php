<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ApiKeyController;

$controller = new ApiKeyController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/generate') {
    $controller->generate();
    exit;
}
if ($path === '/keys') {
    $controller->keys();
    exit;
}
if (preg_match('#^/revoke/(\d+)$#', $path, $matches)) {
    $controller->revoke($matches[1]);
    exit;
}
if ($path === '/validate') {
    $controller->validate();
    exit;
}

$controller->index();
