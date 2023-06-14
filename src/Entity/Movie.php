<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private ?int $id;
    private ?int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;



    /**
     * @return int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @param int $posterId
     * @return Movie
     */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Movie
     */
    private function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @param string $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string|null $overview
     * @return Movie
     */
    public function setOverview(?string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @return Movie
     */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     * @return Movie
     */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @param string|null $tagline
     * @return Movie
     */
    public function setTagline(?string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    public static function findById($id)
    {

        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT posterId, id, originalLanguage, originalTitle, 
                   overview, releaseDate, runtime, tagline, title
            FROM movie
            WHERE id = :movieId
        SQL
        );

        $stmt->bindValue(':movieId', "$id");

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);

        $movie = $stmt->fetch() ;

        if (!$movie) {
            throw new EntityNotFoundException("Aucun Film n'existe pour cet id");
        }

        return $movie;

    }

    public function delete(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
DELETE FROM movie
WHERE id = :id
SQL
        );
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $this->id = null;
        return $this;
    }

    public function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
UPDATE movie
SET title = :title, originalTitle = :originalTitle, overview = :overview, releaseDate = :releaseDate, 
    runtime = :runtime, tagline = :tagline, originalLanguage = :originalLanguage
WHERE id = :id
SQL
        );
        $stmt->bindValue(':title', $this->title);
        $stmt->bindValue(':originalTitle', $this->originalTitle);
        $stmt->bindValue(':overview', $this->overview);
        $stmt->bindValue(':releaseDate', $this->releaseDate);
        $stmt->bindValue(':runtime', $this->runtime);
        $stmt->bindValue(':tagline', $this->tagline);
        $stmt->bindValue(':originalLanguage', $this->originalLanguage);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        return $this;
    }

    public static function create(string $originalLanguage, string $originalTitle, ?string $overview = null, string $releaseDate, int $runtime, ?string $tagline = null, string $title, ?int $id = null)
    {
        $movie = new Movie();
        $movie->setOriginalLanguage($originalLanguage);
        $movie->setOriginalTitle($originalTitle);
        $movie->setOverview($overview);
        $movie->setReleaseDate($releaseDate);
        $movie->setRuntime($runtime);
        $movie->setTagline($tagline);
        $movie->setTitle($title);
        $movie->setId($id);

        return $movie;
    }

    public function insert(): Movie
    {
        $pdo = MyPdo::getInstance();
        $stmt = $pdo->prepare(
            <<<SQL
INSERT INTO movie (originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title)
    VALUES (:originalLanguage, :originalTitle, :overview, :releaseDate, :runtime, :tagline, :title)
SQL
        );
        $stmt->bindValue(':originalLanguage', $this->originalLanguage);
        $stmt->bindValue(':originalTitle', $this->originalTitle);
        $stmt->bindValue(':overview', $this->overview);
        $stmt->bindValue(':releaseDate', $this->releaseDate);
        $stmt->bindValue(':runtime', $this->runtime);
        $stmt->bindValue(':tagline', $this->tagline);
        $stmt->bindValue(':title', $this->title);

        $stmt->execute();

        $this->id = intval($pdo->lastInsertId());
        return $this;
    }

    public function save(): Movie
    {
        if($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;
    }
}
