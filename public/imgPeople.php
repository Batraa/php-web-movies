<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Image;
use Exception\ParameterException;

try {
    if (!isset($_GET['imageId']) or empty($_GET['imageId']) or ctype_digit($_GET['imageId']) == false) {
        throw new ParameterException("Le paramètre n'est pas bon");
    }
    $imageId = (int)($_GET['imageId']);
    $image = Image::findById($imageId);
    header('Content-type: image/jpeg');
    $rep = $image->getJpeg();
    echo $rep;
} catch (ParameterException) {
    header('Content-type: image/jpeg');
    header('Location: http://localhost:8000/img/peopleError.jpeg');
    exit();
} catch (EntityNotFoundException) {
    header('Content-type: image/jpeg');
    header('Location: http://localhost:8000/img/peopleError.jpeg');
    exit();
} catch (Exception) {
    http_response_code(500);
}
