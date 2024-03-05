<?php

declare(strict_types=1);

use App\Domain\PostalCode\PostalCodeRepository;
use App\Infrastructure\Persistence\PostalCode\InDbPostalCodeRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PostalCodeRepository::class =>  \DI\autowire(InDbPostalCodeRepository::class),
    ]);
};
