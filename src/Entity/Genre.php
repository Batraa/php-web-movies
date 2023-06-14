<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use PDO;

class Genre
{
    public int $id;
    public string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Genre
     */
    public function setId(int $id): Genre
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName(string $name): Genre
    {
        $this->name = $name;
        return $this;
    }

    public static function findById($id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
SELECT id, name
FROM genre
WHERE id = :id
SQL
        );

        $stmt->bindValue(':id', $id);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        $genre = $stmt->fetch();

        if (!$genre) {
            throw new EntityNotFoundException("Aucun genre n'existe pour cet id");
        }

        return $genre;
    }
}
