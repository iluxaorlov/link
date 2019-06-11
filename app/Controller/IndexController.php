<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class IndexController extends AbstractController
{
    public function index(Request $request, Response $response)
    {
        return $this->container->view->render($response, 'index/index.twig');
    }
}