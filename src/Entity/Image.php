<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\ParameterException;
use PDO;

class Image
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Image
     */
    public function setId(int $id): Image
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @param string $jpeg
     * @return Image
     */
    public function setJpeg(string $jpeg): Image
    {
        $this->jpeg = $jpeg;
        return $this;
    }

    public static function findById(int $id): Image
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM image
            WHERE id = :imageID
        SQL
        );

        $stmt->bindValue(':imageID', "$id");

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, Image::class);

        $image = $stmt->fetch() ;

        if (!$image) {
            throw new ParameterException("Le paramètre n'est pas bon");
        }
        return $image;

    }
}
