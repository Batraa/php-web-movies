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
                        <p>
                        <label>Titre<input required="required" name="title" type="text" value="{$this->escapeString($this->getMovie()?->getTitle())}"></label> 
                        <p>
                        <label>Titre original<input required="required" name="originalTitle" type="text" value="{$this->escapeString($this->getMovie()?->getOriginalTitle())}"></label> 
                        <p>
                        <label>Langue originale<input required="required" name="originalLanguage" type="text" value="{$this->escapeString($this->getMovie()?->getOriginalLanguage())}"></label>
                        <p>
                        <label>Description<input required="required" name="overview" type="text" value="{$this->escapeString($this->getMovie()?->getOverview())}"></label>
                        <p>
                        <label>Date de sortie<input required="required" name="releaseDate" type="text" value="{$this->escapeString($this->getMovie()?->getReleaseDate())}"></label>
                        <p>
                        <label>Durée<input required="required" name="runtime" type="text" value="{$this->escapeString(strval($this->getMovie()?->getRuntime()))}"></label>
                        <p>
                        <label>Slogan<input required="required" name="tagline" type="text" value="{$this->escapeString($this->getMovie()?->getTagline())}"></label>
                        <p>
                        <button type="submit">Enregistrer</button>	
                    </form>                 
            HTML;
    }

    /**
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {


        if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
            $id = null;
        } else {
            $id = ((int)$_POST['id']);
        }

        if (!isset($_POST['title'])) {
            throw new ParameterException("Le titre du film n'est pas présent");
        } else {
            $title = $this->stripTagsAndTrim($_POST['title']);
        }

        if (!isset($_POST['originalTitle'])) {
            throw new ParameterException("Le titre original du film n'est pas présent");
        } else {
            $originalTitle = $this->stripTagsAndTrim($_POST['originalTitle']);
        }

        if (!isset($_POST['originalLanguage'])) {
            throw new ParameterException("La langue originale du film n'est pas présente");
        } else {
            $originalLanguage = $this->stripTagsAndTrim($_POST['originalLanguage']);
        }

        if (!isset($_POST['overview'])) {
            throw new ParameterException("La description du film n'est pas présente");
        } else {
            $overview = $this->stripTagsAndTrim($_POST['overview']);
        }

        if (!isset($_POST['releaseDate'])) {
            throw new ParameterException("la date de sortie du film n'est pas présente");
        } else {
            $releaseDate = $this->stripTagsAndTrim($_POST['releaseDate']);
        }

        if (!isset($_POST['runtime']) || !ctype_digit($_POST['runtime'])) {
            throw new ParameterException("La durée du film n'est pas présente");
        } else {
            $runtime = $this->stripTagsAndTrim($_POST['runtime']);
        }

        if (!isset($_POST['tagline'])) {
            throw new ParameterException("Le slogan du film n'est pas présente");
        } else {
            $tagline = $this->stripTagsAndTrim($_POST['tagline']);
        }

        $movie = Movie::create($originalLanguage, $originalTitle, $overview, $releaseDate, intval($runtime), $tagline, $title, $id);

        $this->movie = $movie;

    }
}
