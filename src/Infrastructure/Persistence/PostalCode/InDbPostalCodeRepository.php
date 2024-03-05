<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\PostalCode;

use App\Application\Database\DatabaseInterface;
use App\Domain\DomainException\DomainRecordNotFoundException;
use App\Domain\PostalCode\PostalCode;
use App\Domain\PostalCode\PostalCodeRepository;
use PDO;

class InDbPostalCodeRepository implements PostalCodeRepository
{
    private const TABLE = 'postal_codes';

    private const CODES_ON_PAGE = 50;

    private array $searchable = [
        'post_code',
        'postal_code',
        'region',
        'district_old',
        'district_new',
        'settlement',
        'region_eng',
        'district_new_eng',
        'settlement_eng',
        'post_office',
        'post_office_eng',
    ];

    public function __construct(private readonly DatabaseInterface $database)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function paginate(?int $page = null): array
    {
        if (null === $page) {
            $page = (int)($_GET['page'] ?? 1);
        }

        // todo: check is sort available
        $sortBy = $_GET['sortBy'] ?? 'post_code';

        $descending = isset($_GET['descending']) && 'true' === strtolower($_GET['descending']);
        $sortDirection = $descending
            ? 'DESC'
            : 'ASC';

        $search = $_GET['search'] ?? '';

        $table = self::TABLE;
        $perPageLimit = self::CODES_ON_PAGE;

        $totalCountQuery = "SELECT COUNT(*) FROM {$table}";
        $countResult = $this->database->execute($totalCountQuery);

        $totalResults = $countResult['statement']->fetchColumn();

        $totalPages = floor($totalResults / $perPageLimit);

        if ($page === 1) {
            $startingLimit = 0;
        } else {
            $startingLimit = $page * $perPageLimit;
        }

        $whereClause = '';
        if ($search) {
            $whereClause = 'WHERE ';

            $lastKey = end($this->searchable);
            foreach ($this->searchable as $searchable) {
                $whereClause .= "{$searchable} LIKE '%$search%'";
                if ($lastKey !== $searchable) {
                    $whereClause .= ' OR ';
                }
            }
        }

        $query = "SELECT * FROM {$table} {$whereClause} ORDER BY {$sortBy} {$sortDirection} LIMIT {$startingLimit}, {$perPageLimit}";

        $result = $this->database->execute($query);

        if (!$result['is_success']) {
            return [];
        }

        return [
            'total' => $totalResults,
            'current_page' => $page,
            'total_page' => $totalPages,
            'per_page' => $perPageLimit,
            'sort_by' => $sortBy,
            'descending' => $descending,
            'items' => $result['statement']->fetchAll(),
        ];
    }

    /**
     * @throws PostalCodeNotFoundException
     */
    public function findOrFail(string $postCode): PostalCode
    {
        $table = self::TABLE;

        $query = "SELECT * FROM {$table} WHERE `post_code` = ?";

        $result = $this->database->execute($query, [$postCode]);

        if (!$result['is_success']) {
            throw new DomainRecordNotFoundException("Postal code [$postCode] not found");
        }

        $item = $result['statement']->fetch();

        if (!$item) {
            throw new DomainRecordNotFoundException("Postal code [$postCode] not found");
        }

        return new PostalCode(...$item);
    }

    public function delete(PostalCode $postalCode): bool
    {
        $table = self::TABLE;

        $query = "DELETE FROM {$table} WHERE `post_code` = ?";

        $result = $this->database->execute($query, [$postalCode->getPostCode()]);

        return $result['is_success'];
    }

    public function removeImported(): bool
    {
        $table = self::TABLE;

        $query = "DELETE FROM {$table} WHERE `is_imported` = 1";

        $result = $this->database->execute($query);

        return $result['is_success'];
    }

    /**
     * @param array<PostalCode> $items
     * @return bool
     */
    public function bulkInsert(array $items): bool
    {
        $table = self::TABLE;

        $itemsCount = count($items);
        if ($itemsCount === 0) {
            return true;
        }

        [$firstPostalCode] = $items;

        $firstPostalCodePayload = $firstPostalCode->jsonSerialize();
        $columnsKeys = array_keys($firstPostalCodePayload);

        $valueSql = rtrim(str_repeat('?, ', count($columnsKeys)), ', ');
        $valuesSql = rtrim(str_repeat("($valueSql), ", $itemsCount), ', ');

        $columnsSql = implode(', ', $columnsKeys);

        $query = "INSERT IGNORE INTO {$table} ({$columnsSql}) VALUES {$valuesSql}";

        $payload = [];
        foreach ($items as $item) {
            foreach (array_values($item->jsonSerialize()) as $arrayValue) {
                $payload[] = $arrayValue;
            }
        }

        $result = $this->database->execute($query, $payload);

        return $result['is_success'];
    }
}
