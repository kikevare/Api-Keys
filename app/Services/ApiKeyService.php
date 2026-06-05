<?php

namespace App\Services;

use App\Repositories\ApiKeyRepository;

class ApiKeyService
{
    private ApiKeyRepository $repo;

    public function __construct()
    {
        $this->repo = new ApiKeyRepository();
    }

    public function generate(): array
    {
        
        $key = bin2hex(random_bytes(16)); 

        $apiKey = $this->repo->create($key);

        return [
            'id' => $apiKey->id,
            'api_key' => $apiKey->api_key,
            'created_at' => $apiKey->created_at
        ];
    }
    public function list(): array
{
    $keys = $this->repo->all();

    return array_map(function($k) {
        return [
            'id' => $k->id,
            'api_key' => $k->api_key,
            'created_at' => $k->created_at,
            'revoked_at' => $k->revoked_at,
            'is_revoked' => $k->is_revoked
        ];
    }, $keys);
}
public function revoke(int $id): ?array
{
    $key = $this->repo->revoke($id);

    if (!$key) {
        return null;
    }

    return [
        'id' => $key->id,
        'api_key' => $key->api_key,
        'revoked_at' => $key->revoked_at,
        'is_revoked' => $key->is_revoked
    ];
}
public function validate(string $key): bool
{
    $apiKey = $this->repo->findByKey($key);

    if (!$apiKey) {
        return false;
    }

    if ($apiKey->is_revoked == 1) {
        return false;
    }

    return true;
}

}
