<?php

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Model\Direction;

class DirectionController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response)
    {
        $address = $request->getParam('address');
        $address = preg_replace('/\s*/', '', $address);

        if (!preg_match('/^([a-z]+\:\/*)?([a-zа-я0-9]+(\.[a-zа-я0-9]+)+)/', $address)) {
            return $response->withJson([
                'error' => 'Invalid address'
            ])->withStatus(400);
        }

        $direction = Direction::create($address);
        $link = 'https://' . $_SERVER['SERVER_NAME'] . '/' . $direction->getLink();

        SessionController::addLinkToSession($direction->getLink());

        return $response->withJson([
            'link' => $link
        ]);
    }
}