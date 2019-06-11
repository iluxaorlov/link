<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Exception\NotFoundException;
use App\Model\Direction;

class DirectionController
{
    public function create(Request $request, Response $response)
    {
        $address = $request->getParam('address');
        $address = htmlentities($address);

        switch (true) {
            case preg_match('/\s/', $address):
            case !preg_match('/\w{2,}\.\w{2,}/', $address):
                return $response->withStatus(400);
        }

        $direction = Direction::create($address, $response);

        return $response->withJson([
            'direction' => 'https://' . $_SERVER['SERVER_NAME'] . '/' . $direction->getLink(),
        ]);
    }

    public function redirect(Request $request, Response $response, array $args)
    {
        $link = $args['link'];
        $direction = Direction::findOneByLink($link);

        if (!$direction) {
            throw new NotFoundException($request, $response);
        }

        $address = $direction->getScheme() . '://' . $direction->getPath();

        return $response->withRedirect($address);
    }
}