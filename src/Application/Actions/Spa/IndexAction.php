<?php

declare(strict_types=1);

namespace App\Application\Actions\Spa;

use Psr\Http\Message\ResponseInterface as Response;

class IndexAction extends SpaAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view->render($this->response, root_path('templates/index.php'));
    }
}
