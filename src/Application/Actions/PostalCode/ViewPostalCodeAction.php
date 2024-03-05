<?php

declare(strict_types=1);

namespace App\Application\Actions\PostalCode;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class ViewPostalCodeAction extends PostalCodeAction
{
    #[OA\Get(path: '/api/v1/postal_codes/{code}', operationId: 'Get Postal Code')]
    #[OA\Response(response: '200', description: 'Return postal code')]
    protected function action(): Response
    {
        $code = $this->resolveArg('code');

        $postalCode = $this->repository->findOrFail($code);

        return $this
            ->respondWithData($postalCode)
            ->withHeader('Content-Type', 'application/json');
    }
}
