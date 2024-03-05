<?php

declare(strict_types=1);

namespace App\Application\Actions\PostalCode;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class DeletePostalCodeAction extends PostalCodeAction
{
    #[OA\Delete(path: '/api/v1/postal_codes/{code}', operationId: 'Delete Postal Code')]
    #[OA\Response(response: '204', description: '')]
    protected function action(): Response
    {
        $code = $this->resolveArg('code');

        $postalCode = $this->repository->findOrFail($code);

        $this->repository->delete($postalCode);

        return $this->respondWithData(null, 204);
    }
}
