<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Exception\ParameterException;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;

    private ?Movie $movie;

    /**
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    /**
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }
}
