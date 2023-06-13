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
    $movie = Movie::findById($movieId);

    $appWebPage = new AppWebPage("Films - {$movie->getTitle()}");

    $Acteurs = PeopleCollection::findByMovieId($movieId);



    $appWebPage->appendContent("
        <section class='movie__info'>
            <div>
                <img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>
            </div>
            <section class='movie__details'>
                <div class='movie__release_info'>
                    <p>{$appWebPage->escapeString($movie->getTitle())}</p>
                    <p>{$movie->getReleaseDate()}</p>
                </div>
                <div class='movie__additional_info'>
                    <p class='movie__original_title'>{$appWebPage->escapeString($movie->getOriginalTitle())}</p>
                    <p>{$movie->getTagline()}</p>
                    <p>{$movie->getOverview()}</p>
                </div>
            </section>
        </section>
        <section class='actor__list'>");

    foreach ($Acteurs as $people) {
        $appWebPage->appendContent("
            <a href='acteur.php?peopleId={$people->getId()}'>
                <section class='movie__actor'>
                    <div>
                        <img class='people__image' src='imgPeople.php?imageId={$people->getAvatarId()}'>
                    </div>
                    <div class='actor__info'>
                        <p class='actor__role'>{$people->getRoleByIdMovie($movieId)}</p>
                        <p class='actor__name'>{$people->getName()}</p>
                    </div>
                </section>
            </a>
            ");
    }
    $appWebPage->appendContent("</section>");

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
