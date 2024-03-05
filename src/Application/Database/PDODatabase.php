<?php

declare(strict_types=1);

namespace App\Application\Database;

use PDO;

class PDODatabase extends Database
{
    private PDO $pdo;

    public function __construct(
        string $connection,
        string $host,
        int|string $port,
        string $database,
        string $username,
        string $password
    )
    {
        $this->pdo = new PDO(
            "{$connection}:host={$host};port={$port};dbname={$database};",
            $username,
            $password
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function execute(string $query, ?array $bindValues = []): array
    {
        $statement = $this->pdo->prepare($query);

        if (count($bindValues) > 0) {
            $bindValueIdx = 1;
            foreach ($bindValues as $bindValue) {
                $statement->bindValue($bindValueIdx, $bindValue);
                $bindValueIdx++;
            }
        }

        return [
            'is_success' => $statement->execute(),
            'statement' => $statement,
        ];
    }
}
