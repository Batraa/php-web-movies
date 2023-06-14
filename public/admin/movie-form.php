<?php

declare(strict_types=1);

use Entity\Movie;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;
use Html\Form\MovieForm;

try {
    if (!isset($_GET['movieId'])) {
        $artist = null;
    } else {
        if (!ctype_digit($_GET['movieId'])) {
            throw new ParameterException("Le paramètre n'est pas bon");
        }
        $movieId = (int)$_GET['movieId'];
        $artist = Movie::findById($movieId);
    }
    $MovieForm = new MovieForm($artist);

    $webPage = new AppWebPage("Formulaire");
    $webPage->appendContent($MovieForm->getHtmlForm("movie-save.php"));

    echo $webPage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
