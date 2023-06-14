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
    public function getHtmlForm(string $action): string
    {
        return <<<HTML
                    <form name="form" method="POST" action="$action">
                        <input name="id" type="hidden" value="{$this->getMovie()?->getId()}">
                        <label>Titre<input required="required" name="Title" type="text" value="{$this->escapeString($this->getMovie()?->getTitle())}"></label> 
                        <label>Titre original<input required="required" name="originalTitle" type="text" value="{$this->escapeString($this->getMovie()?->getOriginalTitle())}"></label> 
                        <label>Langue originale<input required="required" name="originalLanguage" type="text" value="{$this->escapeString($this->getMovie()?->getOriginalLanguage())}"></label>
                        <label>Description<input required="required" name="overview" type="text" value="{$this->escapeString($this->getMovie()?->getOverview())}"></label>
                        <label>Date de sortie<input required="required" name="releaseDate" type="text" value="{$this->escapeString($this->getMovie()?->getReleaseDate())}"></label>
                        <label>Durée<input required="required" name="runtime" type="text" value="{$this->escapeString($this->getMovie()?->getRuntime())}"></label>
                        <label>Slogan<input required="required" name="tagline" type="text" value="{$this->escapeString($this->getMovie()?->getTagline())}"></label>
                        <button type="submit">Enregistrer</button>	
                    </form>                 
            HTML;
    }
}
