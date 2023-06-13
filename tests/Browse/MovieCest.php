<?php

namespace Tests\Browse;

use Codeception\Example;
use Entity\Artist;
use Tests\BrowseTester;
use Tests\CrudTester;

class MovieCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I)
    {
        $I->amOnPage('/film.php?movieId=630');
        $I->seeResponseCodeIs(200);
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function loadMoviePageWithoutParameter(BrowseTester $I)
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/film.php');
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadMoviePageWithWrongParameter(BrowseTester $I, Example $example)
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/film.php?movieId=' . $example['id']);
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => ''],
            ['id' => 'bad_id_value'],
        ];
    }

    public function loadMoviePageWithUnknownMovieId(BrowseTester $I)
    {
        $I->amOnPage('/film.php?movieId=' . PHP_INT_MAX);
        $I->seeResponseCodeIs(404);
    }

    public function loadMovieAndPeoplesWithCorrectParameter(BrowseTester $I)
    {
        $I->amOnPage('/film.php?movieId=630');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Films - Le Magicien d\'Oz', '.header h1');
        $I->see('Films - Le Magicien d\'Oz', '.header h1');
        $I->assertEquals(
            [
                  'Judy Garland',
                  'Ray Bolger',
                  'Jack Haley',
                  'Bert Lahr',
                  'Margaret Hamilton',
                  'Frank Morgan',
                  'Clara Blandick',
                  'Charley Grapewin',
                  'Billie Burke',
                  'Pat Walshe',
                  'Terry',
                  'Adriana Caselotti',
                  'Harry Earles',
                  'Jerry Maren',
                  'Parnell St. Aubin',
                  'Billy Bletcher',
                  'Pinto Colvig',
                  'Charles Becker',
                  'Mitchell Lewis',
                  'Buster Brodie',
                  'Ethelreda Leopold',
                  'Billy Curtis'
        ], $I->grabMultiple('.content .actor__list .actor__name'));
    }
}
