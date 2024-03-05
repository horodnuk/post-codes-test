<?php

declare(strict_types=1);

namespace App\Application\Actions\PostalCode;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class ListPostalCodesAction extends PostalCodeAction
{
    #[OA\Get(path: '/api/v1/postal_codes', operationId: 'Get All Postal Codes')]
    #[OA\Response(response: '200', description: 'Return paginated list')]
    protected function action(): Response
    {
        $postCodes = $this->repository->paginate();

        return $this
            ->respondWithData($postCodes)
            ->withHeader('Content-Type', 'application/json');
    }
}
