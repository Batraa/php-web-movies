<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (!isset($_GET['peopleId']) or empty($_GET['peopleId']) or ctype_digit($_GET['peopleId']) == false) {
        throw new ParameterException("Le paramètre n'est pas bon");
    }
    $peopleId = (int)($_GET['peopleId']);

    $appWebPage = new AppWebPage();

    $people = People::findById($peopleId);

    $films = MovieCollection::findByPeopleId($peopleId);

    $nomActeur = $people->getName();

    $appWebPage->setTitle("Films - {$nomActeur}");

    $appWebPage->appendContent("<div><div><img class='people__image' src='imgPeople.php?imageId={$people->getAvatarId()}'></div>");
    $appWebPage->appendContent("<div><p>{$nomActeur}</p><p>{$people->getPlaceOfBirth()}</p><p>{$people->getBirthday()}</p><p>{$people->getDeathDay()}</p><p>{$people->getBiography()}</p>");
    $appWebPage->appendContent("</div></div>");

    foreach ($films as $film) {
        $appWebPage->appendContent("<a href='film.php?movieId={$film->getId()}'><div><img class='movie__image' src='imgMovie.php?imageId={$film->getPosterId()}'></div>");
        $appWebPage->appendContent("<div><p>{$film->getRoleByIdPeople($peopleId)}</p><p>{$appWebPage->escapeString($film->getTitle())}</p></div>");
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