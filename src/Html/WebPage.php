<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;

    protected string $head = "";
    protected string $title = "";
    protected string $body = "";

    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    public function appendContent(string $content)
    {
        $this->body .= $content;
    }

    public function appendToHead(string $content)
    {
        $this->head .= $content;
    }

    public function appendCss(string $css)
    {
        $this->head .= "<style>$css</style>";
    }

    public function appendCssUrl(string $url)
    {
        $this->head .= "<link rel=\"stylesheet\" media=\"screen\" href=\"{$url}\">";
    }

    public function appendJs(string $js)
    {
        $this->head .= "<script>$js</script>";
    }

    public function appendJsUrl(string $url)
    {
        $this->head .= "<script src =\"$url\"></script>";
    }

    public function toHTML()
    {
        return <<<HTML
        <!DOCTYPE HTML>
            <html lang="fr" >
                <head>
                    <meta charset="UTF-8" name="viewport">
                    <title>$this->title</title>
                    $this->head
                </head>
                <body>
                    $this->body
                </body>
            </html>            
        HTML;



    }

    public function getLastModification()
    {
        $date = date("F d Y H:i:s.", getlastmod());
        return $date;
    }


}
