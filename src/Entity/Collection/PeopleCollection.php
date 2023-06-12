<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;

class PeopleCollection
{
    /** Retourne un tableau contenant tous les artistes triés par ordre alphabétique
     *
     * @return People[]
     */
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT p.id,p.avatarId,p.birthday,p.deathday,p.name,p.biography,p.placeOfBirth
            FROM people p
            JOIN cast c on c.peopleId = p.id
            WHERE c.movieId = :movieId
            ORDER BY p.name
        SQL
        );

        $stmt->bindValue(':movieId', "$movieId");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, People::class);

    }

}