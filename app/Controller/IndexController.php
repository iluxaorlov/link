<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class IndexController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function index(Request $request, Response $response)
    {
        $links = SessionController::getLinksFromSession();

        return $this->container->view->render($response, 'index/index.twig', [
            'links' => $links
        ]);
    }
}