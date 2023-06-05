<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->appendCssUrl("css/style.css");
    }

    public function toHTML(): string
    {
        $LastModif = $this->getLastModification();

        return <<<HTML
            <!DOCTYPE HTML>
            <html lang="fr" >
                <head>
                    <meta charset="UTF-8" name="viewport">
                    <title>{$this->title}</title>
                    $this->head
                </head>
                <body>
                    <header class="header">
                        <h1>$this->title</h1>
                    </header>
                    <main class="content">
                        $this->body
                    </main>
                    <footer class="footer">
                        Dernière modification : $LastModif
                    </footer>
                </body>
            </html>        
        HTML;
    }
}
