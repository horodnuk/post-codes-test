<?php

declare(strict_types=1);

namespace App\Application\Database;

abstract class Database implements DatabaseInterface
{
    abstract public function execute(string $query): array;
}
