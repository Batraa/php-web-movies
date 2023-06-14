<?php

namespace Tests\Browse;

use Codeception\Example;
use Tests\BrowseTester;

class imgPeopleCest
{
    public function loadImgPeopleWithoutParameter(BrowseTester $I)
    {
        $I->amOnPage('/imgPeople.php');
        $I->seeResponseCodeIs(200);
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadImgPeopleWithWrongParameter(BrowseTester $I, Example $example)
    {
        $I->amOnPage('/imgPeople.php?imageId=' . $example['id']);
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

    public function loadImgPeopleWithCorrectParameter(BrowseTester $I)
    {
        $I->amOnPage('/imgPeople.php?imageId=16731');
        $I->seeResponseCodeIs(200);
        $I->haveHttpHeader('Content-Type', 'image/jpeg');
        $I->seeResponseContentIs(file_get_contents(codecept_data_dir() . '/img/imgPeople.jpg'));
    }
}
