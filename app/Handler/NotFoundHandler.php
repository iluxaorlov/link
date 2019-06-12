<?php

namespace App\Handler;

use Slim\Handlers\AbstractHandler;
use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundHandler extends AbstractHandler
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->view->render($response, 'error/404.twig')->withStatus(404);
    }
}