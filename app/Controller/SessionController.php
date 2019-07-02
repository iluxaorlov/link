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

    public static function addLink(string $link): void
    {
        self::startSession();

        $_SESSION['link'] = $link;
    }

    /**
     * @return string|null
     */
    public static function getLink(): ?string
    {
        self::startSession();

        if ($_SESSION['link']) {
            $direction = Direction::findOneByLink($_SESSION['link']);

            if ($direction) {
                return 'https://' . $_SERVER['SERVER_NAME'] . '/' . $direction->getLink();
            }
        }

        return null;
    }
}