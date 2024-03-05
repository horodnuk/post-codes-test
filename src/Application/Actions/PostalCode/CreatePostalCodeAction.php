<?php

declare(strict_types=1);

namespace App\Application\Actions\PostalCode;

use App\Domain\PostalCode\PostalCode;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;
use Valitron\Validator;

class CreatePostalCodeAction extends PostalCodeAction
{
    #[OA\Post(path: '/api/v1/postal_codes', operationId: 'Create Postal Code')]
    #[OA\Response(response: '200', description: 'Return post code')]
    protected function action(): Response
    {
        $payload = $this->getFormData();

        $v = new Validator($payload);
        $v->rules([
            'required' => ['post_code', 'postal_code', 'region'],

            'lengthMin' => [
                ['post_code', 5],
                ['postal_code', 5],
            ],

            'lengthMax' => [
                ['post_code', 5],
                ['postal_code', 5],
            ],
        ]);

        if (!$v->validate()) {
            return $this
                ->respondWithData([
                    'message' => 'Validation error',
                    'errors' => $v->errors(),
                ])
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        }

        $postCodeDto = new PostalCode(...$payload);

        $this->repository->bulkInsert([$postCodeDto]);

        return $this
            ->respondWithData($postCodeDto)
            ->withHeader('Content-Type', 'application/json');
    }
}
