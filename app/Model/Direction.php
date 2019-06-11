<?php

declare(strict_types = 1);

namespace App\Model;

use App\Database\Database;

class Direction extends Record
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $date;

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'direction';
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return self
     */
    public function setScheme(string $scheme): self
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return self
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param string $address
     * @return self
     */
    public static function create(string $address): self
    {
        $direction = new self();
        $direction->setScheme(self::parseScheme($address))
                  ->setPath(self::parsePath($address))
                  ->setLink(self::generateLink())
                  ->write();

        return $direction;
    }

    /**
     * @param string $address
     * @return string
     */
    private static function parseScheme(string $address): string
    {
        $address = self::clearAddress($address);
        $schemeMatch = preg_match('/^\w*:\/*/', $address, $matches);
        $scheme = $matches[0];
        $scheme = preg_replace('/:\/+$/', '', $scheme);

        return $scheme ?: 'http';
    }

    /**
     * @param string $address
     * @return string
     */
    private static function parsePath(string $address): string
    {
        $address = self::clearAddress($address);
        $path = preg_replace('/^\w*:\/*/', '', $address);
        $path = preg_replace('/\/*$/', '', $path);

        return $path;
    }

    /**
     * @param string $address
     * @return string
     */
    private static function clearAddress(string $address): string
    {
        $address = htmlentities($address);
        $address = preg_replace('/\s*/', '', $address);

        return $address;
    }

    /**
     * @return string
     */
    private static function generateLink(): string
    {
        $symbolsLength = strlen(self::SYMBOLS);

        for ($length = 1; $length <= $symbolsLength; $length++) {
            $countLinksWithLength = self::countLinksWithLength($length);

            while ($countLinksWithLength < $symbolsLength ** $length) {
                $link = '';

                for ($linkLength = 1; $linkLength <= $length; $linkLength++) {
                    $link .= self::SYMBOLS[mt_rand(0, $symbolsLength - 1)];
                }

                $item = self::findOneByLink($link);

                if (!$item) {
                    return $link;
                }
            }
        }
    }

    /**
     * @param int $length
     * @return int
     */
    private static function countLinksWithLength(int $length): int
    {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(*) as count FROM ' . self::getTableName() . ' WHERE LENGTH(link) = :length;';
        $result = $database->query($sql, ['length' => $length], self::class)[0];
        $result = $result->count;

        return (int)$result;
    }

    /**
     * @param string $link
     * @return self|null
     */
    public static function findOneByLink(string $link): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . self::getTableName() . ' WHERE link = :link';
        $result = $database->query($sql, ['link' => $link], self::class)[0];

        return $result;
    }
}