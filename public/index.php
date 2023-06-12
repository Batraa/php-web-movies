<?php

declare(strict_types=1);
use Database\MyPdo;
use Html\AppWebPage;

$webpage = new AppWebPage("Liste des films");

echo $webpage->toHTML();
