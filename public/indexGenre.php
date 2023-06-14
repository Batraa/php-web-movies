<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (!isset($_GET['genreId']) or empty($_GET['genreId'])) {
        throw new ParameterException("Le paramÃ¨tre n'est pas bon");
    }
    $genreId = (int)($_GET['genreId']);

    $webpage = new AppWebPage("Liste des films");

    $movies = MovieCollection::findByGenreId($genreId);

    $webpage->appendContent('<form class="delete__filters_button" action="/index.php" method="POST">
                            <input type="submit" value="Supprimer le filtre">
                        </form>');

    foreach ($movies as $movie) {
        $webpage->appendContent("<a href='film.php?movieId={$movie->getId()}'>
        <section class='movie__content'><img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>
        <div class='movie__title'>{$webpage->escapeString($movie->getTitle())}</div></section></a>");
    }

    echo $webpage->toHTML();

} catch (ParameterException) {
    header('Location: index.php');
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}