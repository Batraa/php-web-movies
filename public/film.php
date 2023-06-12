<?php

declare(strict_types=1);

use Entity\Collection\PeopleCollection;
use Html\AppWebPage;

$webpage = new AppWebPage("Film");

$Acteurs = PeopleCollection::findByMovieId(108);

foreach ($Acteurs as $people) {
    $webpage->appendContent("<p>{$people->getName()}</p>");
}
echo $webpage->toHTML();
