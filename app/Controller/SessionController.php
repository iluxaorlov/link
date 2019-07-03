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

        if (!$_SESSION['links']) {
            $_SESSION['links'] = [];
        }

        if (count($_SESSION['links']) === 3) {
            array_pop($_SESSION['links']);
        }

        array_unshift($_SESSION['links'], $link);
    }

    /**
     * @return array
     */
    public static function getLink(): array
    {
        self::startSession();

        $result = [];

        if ($_SESSION['links']) {
            foreach ($_SESSION['links'] as $link) {
                $direction = Direction::findOneByLink($link);

                if ($direction) {
                    $result[] = 'https://' . $_SERVER['SERVER_NAME'] . '/' . $direction->getLink();
                }
            }
        }

        return $result;
    }
}