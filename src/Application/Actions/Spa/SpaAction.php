<?php

declare(strict_types=1);

namespace App\Application\Actions\Spa;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

abstract class SpaAction extends Action
{
    protected PhpRenderer $repository;

    public function __construct(LoggerInterface $logger, PhpRenderer $view)
    {
        parent::__construct($logger);

        $this->view = $view;
    }
}
