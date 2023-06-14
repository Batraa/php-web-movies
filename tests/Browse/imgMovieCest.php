<?php

namespace Tests\Browse;

use Codeception\Example;
use Tests\BrowseTester;

class imgMovieCest
{
    public function loadImgMovieWithoutParameter(BrowseTester $I)
    {
        $I->amOnPage('/imgMovie.php');
        $I->seeResponseCodeIs(200);
    }

    /**
     * @dataProvider wrongParameterProvider
     **/
    public function loadImgMovieWithWrongParameter(BrowseTester $I, Example $example)
    {
        $I->amOnPage('/imgMovie.php?imageId=' . $example['id']);
        $I->seeResponseCodeIs($example['response']);
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => '', 'response' => 200],
            ['id' => 'bad_id_value', 'response' => 200],
            ['id' => (string)PHP_INT_MAX, 'response' => 200],
        ];
    }

    public function loadImgMovieWithCorrectParameter(BrowseTester $I)
    {
        $I->amOnPage('/imgMovie.php?imageId=16044');
        $I->seeResponseCodeIs(200);
        $I->haveHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContentIs(file_get_contents(codecept_data_dir() . '/img/imgMovie.jpg'));
    }
}
