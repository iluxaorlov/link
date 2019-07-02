<?php

namespace App\Controller;

use App\Model\Direction;

abstract class SessionController
{
    private static function startSession(): void
    {
        session_name('LINKY');
        session_start([
            'cookie_lifetime' => 365 * 24 * 60 * 60
        ]);
    }

    /**
     * @param string $link
     */
    public static function addLinkToSession(string $link): void
    {
        self::startSession();

        if (!$_SESSION['links']) {
            $_SESSION['links'] = [];
        }

        array_unshift($_SESSION['links'], $link);
    }

    /**
     * @return array
     */
    public static function getLinksFromSession(): array
    {
        self::startSession();

        $links = [];

        foreach ($_SESSION['links'] as $link) {
            $direction = Direction::findOneByLink($link);

            if ($direction) {
                $links[] = 'https://' . $_SERVER['SERVER_NAME'] . '/' . $direction->getLink();
            }
        }

        return $links;
    }
}