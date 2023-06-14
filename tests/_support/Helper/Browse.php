<?php
namespace Tests\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Browse extends \Codeception\Module
{
    public function seeResponseContentIs(string $expected, string $message='Response content does not match')
    {
        $this->assertEquals($expected, $this->getModule('PhpBrowser')->_getResponseContent(), $message);
    }
}
