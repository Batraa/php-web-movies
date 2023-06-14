<?php

declare(strict_types=1);

use Entity\Movie;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (empty($_GET['movieId']) || !ctype_digit($_GET['movieId'])) {
        throw new ParameterException("Le paramètre n'est pas bon");
    }
    $id = (int)$_GET['movieId'];
    $movie = Movie::findById($id);
    $movie->delete();
    header('Location: /index.php');
    exit();


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
