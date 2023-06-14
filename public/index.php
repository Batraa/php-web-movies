<?php

declare(strict_types=1);
use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;

$webpage = new AppWebPage("Liste des films");

$movies = MovieCollection::findAll();
$genres = GenreCollection::findAll();

$webpage->appendContent("
                        <form class='add__button' action='/admin/movie-form.php' method='POST'>
                            <input type='submit' value='Ajouter'>
                        </form>
                        <form class='genre__list' method='GET' action='/indexGenre.php'>
                            <select name='genreId'>
                                ");

foreach ($genres as $genre) {
    $webpage->appendContent("
    <option value='{$genre->getId()}'>{$genre->getName()}</option>
    ");
}
$webpage->appendContent("</select>
                                <input type='submit' value='Filtrer'>
                            </form>");

foreach ($movies as $movie) {
    $webpage->appendContent("<a href='film.php?movieId={$movie->getId()}'>
        <section class='movie__content'><img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>
        <div class='movie__title'>{$webpage->escapeString($movie->getTitle())}</div></section></a>");
}

echo $webpage->toHTML();
