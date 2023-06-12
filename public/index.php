<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;

$webpage = new AppWebPage("Liste des films");

$movies = MovieCollection::findAll();

foreach ($movies as $movie){
    $webpage->appendContent("<p><div>{$movie->getTitle()}</div>");
}

echo $webpage->toHTML();