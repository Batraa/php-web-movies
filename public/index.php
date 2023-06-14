<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;

$webpage = new AppWebPage("Liste des films");

$movies = MovieCollection::findAll();

$webpage->appendContent("
                        <form action='/admin/movie-form.php' method='POST'>
                            <input type='submit' value='Ajouter'>
                        </form>");

foreach ($movies as $movie) {
    $webpage->appendContent("<a href='film.php?movieId={$movie->getId()}'>
        <section class='movie__content'><img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>
        <div class='movie__title'>{$webpage->escapeString($movie->getTitle())}</div></section></a>");
}

echo $webpage->toHTML();

