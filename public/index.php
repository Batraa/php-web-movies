<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;

$webpage = new AppWebPage("Liste des films");

$movies = MovieCollection::findAll();



foreach ($movies as $movie){
    $webpage->appendContent("<a href='film.php?movieId={$movie->getId()}'>");
    $webpage->appendContent("<div><img class='movie__image' src='imgMovie.php?imageId={$movie->getPosterId()}'>");
    $webpage->appendContent("<p>{$movie->getOriginalTitle()}</p></div></a>");
}

echo $webpage->toHTML();