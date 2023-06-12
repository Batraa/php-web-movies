<?php

declare(strict_types=1);

namespace Entity\Collection;

use PDO;
use Entity\Movie;
use Database\MyPdo;

class MovieCollection
{
    /** Récupère tous les films de la base de donnée
     * @return Movie[]
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT posterId, id, originalLanguage, originalTitle, 
                   overview, releaseDate, runtime, tagline, title
            FROM movie
            ORDER BY title;
            SQL
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    public static function findByPeopleId($peopleId)
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT DISTINCT posterId, id, originalLanguage, originalTitle, 
                   overview, releaseDate, runtime, tagline, title
            FROM movie m
                JOIN cast c ON m.id = c.movieId
            WHERE peopleId = :peopleId
            ORDER BY title;
            SQL
        );

        $stmt->bindValue(':peopleId', "$peopleId");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }
}
