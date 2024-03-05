<?php

declare(strict_types=1);

namespace App\Application\Actions\PostalCode;

use App\Application\Actions\Action;
use App\Application\Database\DatabaseInterface;
use App\Domain\PostalCode\PostalCodeRepository;
use Psr\Log\LoggerInterface;

abstract class PostalCodeAction extends Action
{
    protected PostalCodeRepository $repository;
    protected DatabaseInterface $database;

    public function __construct(LoggerInterface $logger, PostalCodeRepository $repository, DatabaseInterface $database)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->database = $database;
    }
}
