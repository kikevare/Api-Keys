<?php

namespace App\Models;

class ApiKey
{
    public int $id;
    public string $api_key;
    public string $created_at;
    public ?string $revoked_at;
    public int $is_revoked;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? 0;
        $this->api_key = $data['api_key'] ?? '';
        $this->created_at = $data['created_at'] ?? '';
        $this->revoked_at = $data['revoked_at'] ?? null;
        $this->is_revoked = $data['is_revoked'] ?? 0;
    }
}
