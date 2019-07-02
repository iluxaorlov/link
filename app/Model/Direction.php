<?php

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
    protected $address;

    /**
     * @var string
     */
    protected $link;

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
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
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
        $direction
            ->setAddress(self::parseAddress($address))
            ->setLink(self::generateLink())
            ->write();

        return $direction;
    }

    /**
     * @param string $address
     * @return string
     */
    private static function parseAddress(string $address): string
    {
        $address = preg_replace('/\s*/', '', $address);

        if (!preg_match('/^([A-Za-z]{2,}\:\/*)/', $address)) {
            $address = 'http://' . $address;
        }

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
        $result = $database->query($sql, ['link' => $link], self::class);
        $result = $result[0];

        return $result;
    }
}