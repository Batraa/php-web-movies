<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $MovieForm = new MovieForm();
    $MovieForm->setEntityFromQueryString();
    $MovieForm->getMovie()->save();
    header('Location: /index.php');
    exit();

} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
