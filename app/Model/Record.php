<?php

namespace App\Model;

use ReflectionClass;
use App\Database\Database;

abstract class Record
{
    protected const SYMBOLS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    abstract protected static function getTableName();

    protected function write(): void
    {
        if ($this->id === null) {
            $this->setId(self::generateId());
            $propertiesArray = $this->databaseFormat();
            self::insert($propertiesArray);
        } else {
            $propertiesArray = $this->databaseFormat();
            self::update($propertiesArray);
        }
    }

    /**
     * @return array
     */
    private function databaseFormat(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertiesArray[$propertyName] = $this->$propertyName;
        }

        return $propertiesArray;
    }

    /**
     * @return string
     */
    private static function generateId(): string
    {
        $symbolsLength = strlen(self::SYMBOLS);

        while (true) {
            $id = '';

            for ($i = 0; $i < $symbolsLength; $i++) {
                $id .= self::SYMBOLS[mt_rand(0, $symbolsLength - 1)];
            }

            $item = self::findOneById($id);

            if (!$item) {
                return $id;
            }
        }
    }

    /**
     * @param string $id
     * @return self|null
     */
    private static function findOneById(string $id): ?self
    {
        $database = Database::getInstance();
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id';
        $result = $database->query($sql, ['id' => $id], static::class)[0];

        return $result;
    }

    /**
     * @param array $propertiesArray
     */
    private static function insert(array $propertiesArray): void
    {
        $propertiesArray = array_filter($propertiesArray);

        foreach ($propertiesArray as $column => $value) {
            $parameter = ':' . $column;
            $columns[] = $column;
            $parameters[] = $parameter;
            $parametersToValues[$parameter] = $value;
        }

        $database = Database::getInstance();
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $parameters) . ');';
        $database->query($sql, $parametersToValues, static::class);
    }

    /**
     * @param array $propertiesArray
     */
    private static function update(array $propertiesArray): void
    {
        $propertiesArrayFilter = array_filter($propertiesArray);

        foreach ($propertiesArrayFilter as $column => $value) {
            $parameter = ':' . $column;
            $parameters[] = $column . ' = ' . $parameter;
            $parametersToValues[$parameter] = $value;
        }

        $database = Database::getInstance();
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $parameters) . ' WHERE id = :id;';
        $database->query($sql, $parametersToValues, static::class);
    }
}
