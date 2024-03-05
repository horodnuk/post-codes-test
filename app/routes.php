<?php

declare(strict_types=1);

use App\Application\Actions\PostalCode\CreatePostalCodeAction;
use App\Application\Actions\PostalCode\DeletePostalCodeAction;
use App\Application\Actions\PostalCode\ListPostalCodesAction;
use App\Application\Actions\PostalCode\ViewPostalCodeAction;
use App\Application\Actions\Spa\IndexAction;
use App\Application\Validation\CreatePostalCodeValidation;
use DavidePastore\Slim\Validation\Validation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/api/v1/postal_codes', function (Group $group) {
        $group->get('', ListPostalCodesAction::class);

        $group->post('', CreatePostalCodeAction::class);

        $group->delete('/{code}', DeletePostalCodeAction::class);

        $group->get('/{code}', ViewPostalCodeAction::class);
    });

    $app->get('/{routes:.*}', IndexAction::class);
};
