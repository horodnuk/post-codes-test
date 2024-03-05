<?php

declare(strict_types=1);

namespace App\Domain\PostalCode;

interface PostalCodeRepository
{
    /**
     * @return PostalCode[]
     */
    public function paginate(): array;

    public function findOrFail(string $postCode): PostalCode;

    public function delete(PostalCode $postalCode): bool;

    public function bulkInsert(array $items): bool;

    public function removeImported(): bool;
}
