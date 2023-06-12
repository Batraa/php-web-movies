<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    public function escapeString(?string $string): ?string
    {
        $retour = "";
        if ($string != null) {
            $retour = htmlspecialchars($string, ENT_QUOTES|ENT_HTML5);
        }
        return $retour;
    }

    public function stripTagsAndTrim(?string $string): ?string
    {
        $chaine = $string;
        if ($chaine == null) {
            $chaine = "";
        } else {
            $chaine = strip_tags((string)$chaine);
            $chaine = trim($chaine);
        }
        return $chaine;
    }
}
