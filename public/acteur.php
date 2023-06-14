<?php

declare(strict_types=1);

use Entity\Cast;
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
    $people = People::findById($peopleId);

    $appWebPage = new AppWebPage("Films - {$people->getName()}");

    $movies = MovieCollection::findByPeopleId($peopleId);

    $appWebPage->appendContent("
                <div class='actor__page'>
                    <section class='actor__profile'>
                        <img class='people__image' src='imgPeople.php?imageId={$people->getAvatarId()}'>
                        <div class='actor__profile_info'>
                            <p>{$people->getName()}</p>
                            <p>{$people->getPlaceOfBirth()}</p>
                            <div class='actor__birthdate'>
                                <p>{$people->getBirthday()}</p>
                                <p>{$people->getDeathDay()}</p>
                            </div>
                                <p>{$people->getBiography()}</p>    
                        </div>
                    </section>");



    foreach ($movies as $movie) {
        $role = Cast::getByMovieIdAndPeopleId($movie->getId(), $people->getId())->getRole();
        $appWebPage->appendContent("
        <a href='film.php?movieId={$movie->getId()}' class='actor__movies'>
                <img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>
            <div class='actor__films_info'>
                <div class='actor__role_date'>
                    <p>{$role}</p>
                    <p>{$movie->getReleaseDate()}</p>
                 </div>
                <p>{$appWebPage->escapeString($movie->getTitle())}</p>
            </div>
        </a>");
    }
    $appWebPage->appendContent("</section></div>");
    echo $appWebPage->toHTML();

} catch (ParameterException) {
    header('Location: index.php');
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
