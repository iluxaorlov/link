<?php

namespace App\Controller;

use App\Model\Direction;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class RedirectController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @throws NotFoundException
     * @return Response
     */
    public function redirect(Request $request, Response $response, array $args)
    {
        $link = $args['link'];
        $direction = Direction::findOneByLink($link);

        if ($direction) {
            return $response->withRedirect($direction->getAddress());
        }

        throw new NotFoundException($request, $response);
    }
}
