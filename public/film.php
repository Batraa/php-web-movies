<?php

declare(strict_types=1);

use Entity\Collection\PeopleCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (!isset($_GET['movieId']) or empty($_GET['movieId']) or ctype_digit($_GET['movieId']) == false) {
        throw new ParameterException("Le paramètre n'est pas bon");
    }
    $movieId = (int)($_GET['movieId']);

    $appWebPage = new AppWebPage();

    $movie = Movie::findById($movieId);

    $Acteurs = PeopleCollection::findByMovieId($movieId);

    $titreFr = $appWebPage->escapeString($movie->getTitle());
    $titreOr = $appWebPage->escapeString($movie->getOriginalTitle());

    $appWebPage->setTitle("Films - {$titreFr}");

    $appWebPage->appendContent("<div><div><img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'></div>");
    $appWebPage->appendContent("<div><p>{$titreFr}</p><p>{$movie->getReleaseDate()}</p><p>{$titreOr}</p><p>{$movie->getTagline()}</p><p>{$movie->getOverview()}</p>");
    $appWebPage->appendContent("</div></div>");

    foreach ($Acteurs as $people) {
        $appWebPage->appendContent("<a href='acteur.php?peopleId={$people->getId()}'><div><img class='people__image' src='imgPeople.php?imageId={$people->getAvatarId()}'></div>");
        $appWebPage->appendContent("<div><p>{$people->getRoleByIdMovie($movieId)}</p><p>{$people->getName()}</p></div>");
    }

    echo $appWebPage->toHTML();
} catch (ParameterException) {
    header('Location: http://localhost:8000/index.php');
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
    header('Location: http://localhost:8000/index.php');
    exit();
} catch (Exception) {
    http_response_code(500);
}
