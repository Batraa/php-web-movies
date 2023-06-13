<?php

namespace Tests\Browse;

use Tests\BrowseTester;

class IndexCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('films');
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->see('films', '.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function listAllArtists(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->see('films', 'h1');
        $I->seeElement('.content a');
        $I->assertEquals(
            [
                'Dragon Ball Super - Broly',
                'Le Magicien d\'Oz',
                'Trois couleurs : Blanc',
                'Trois couleurs : Bleu',
                'Trois couleurs : Rouge',
                '鬼滅の刃 鼓屋敷編',

            ],
            $I->grabMultiple('.content .movie__title')
        );
    }

    public function clickOnArtistLink(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->click('Le Magicien d\'Oz');
        $I->seeInCurrentUrl('/film.php?movieId=630');
    }
}
