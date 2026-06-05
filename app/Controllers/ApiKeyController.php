<?php

namespace App\Controllers;

use App\Services\ApiKeyService;

class ApiKeyController
{
    public function index()
    {
        echo json_encode([
            'message' => 'API Keys controller funcionando'
        ]);
    }
    public function generate()
    {
        $service = new ApiKeyService();
        $result = $service->generate();

        echo json_encode($result);
    }
    public function keys()
    {
        $service = new ApiKeyService();
        $result = $service->list();

        echo json_encode($result);
    }
    public function revoke($id)
    {
        $service = new ApiKeyService();
        $result = $service->revoke((int)$id);

        if (!$result) {
            echo json_encode(['error' => 'API key no encontrada']);
            return;
        }

        echo json_encode($result);
    }
    public function validate()
{
    $key = $_GET['key'] ?? null;

    if (!$key) {
        echo json_encode(['error' => 'Falta parámetro key']);
        return;
    }

    $service = new ApiKeyService();
    $valid = $service->validate($key);

    echo json_encode(['valid' => $valid]);
}

}
