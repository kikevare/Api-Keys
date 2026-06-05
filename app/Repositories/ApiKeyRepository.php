<?php

namespace App\Repositories;

use App\Models\ApiKey;
use PDO;

class ApiKeyRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO('sqlite:' . __DIR__ . '/../../Database/database.sqlite');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function create(string $apiKey): ApiKey
    {
        $stmt = $this->db->prepare("
            INSERT INTO api_keys (api_key, created_at)
            VALUES (:api_key, :created_at)
        ");

        $stmt->execute([
            ':api_key' => $apiKey,
            ':created_at' => date('Y-m-d H:i:s')
        ]);

        $id = $this->db->lastInsertId();

        return $this->find($id);
    }

    public function find(int $id): ?ApiKey
    {
        $stmt = $this->db->prepare("SELECT * FROM api_keys WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new ApiKey($data) : null;
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM api_keys ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new ApiKey($row), $rows);
    }
    public function revoke(int $id): ?ApiKey
{
    $stmt = $this->db->prepare("
        UPDATE api_keys
        SET is_revoked = 1,
            revoked_at = :revoked_at
        WHERE id = :id
    ");

    $stmt->execute([
        ':revoked_at' => date('Y-m-d H:i:s'),
        ':id' => $id
    ]);

    return $this->find($id);
}
public function findByKey(string $key): ?ApiKey
{
    $stmt = $this->db->prepare("SELECT * FROM api_keys WHERE api_key = :key LIMIT 1");
    $stmt->execute([':key' => $key]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data ? new ApiKey($data) : null;
}

}
