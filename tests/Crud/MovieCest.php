<?php

namespace Tests\Crud;

use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Tests\CrudTester;

class MovieCest
{
    public function findById(CrudTester $I)
    {
        $movie = Movie::findById(108);
        $I->assertSame(108, $movie->getId());
        $I->assertSame('Trois couleurs : Bleu', $movie->getTitle());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Movie::findById(PHP_INT_MAX);
        });
    }

    public function delete(CrudTester $I)
    {
        $movie = Movie::findById(108);
        $movie->delete();
        $I->cantSeeInDatabase('movie', ['id' => 108]);
        $I->cantSeeInDatabase('movie', ['title' => 'Trois couleurs : Bleu']);
        $I->assertNull($movie->getId());
        $I->assertSame('Trois couleurs : Bleu', $movie->getTitle());
    }

    public function update(CrudTester $I)
    {
        $movie = Movie::findById(108);
        $movie->setTitle('Aladdin');
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'id' => 108,
            'title' => 'Aladdin'
        ]);
        $I->assertSame(108, $movie->getId());
        $I->assertSame('Aladdin', $movie->getTitle());
    }

    public function createWithoutId(CrudTester $I)
    {
        $movie = Movie::create('French', 'Taxi 3', '', '2003-01-29', 10, '', 'Taxi 3');
        $I->assertNull($movie->getId());
        $I->assertSame('Taxi 3', $movie->getTitle());
    }

    public function createWithId(CrudTester $I)
    {
        $movie = Movie::create('French', 'Taxi 3', '', '2003-01-29', 10, '', 'Taxi 3', 200);
        $I->assertSame(200, $movie->getId());
        $I->assertSame('Taxi 3', $movie->getTitle());
    }

    /**
     * @after createWithoutId
     */
    # Ce test n'est pas encore fonctionnel
    public function insert(CrudTester $I)
    {
        $movie = Movie::create('French', 'Taxi 3', '', '2003-01-29', 10, '', 'Taxi 3', 200);
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'originalLanguage' => 'French',
            'originalTitle' => 'Taxi 3',
            'overview' => '',
            'releaseDate' => '2003-01-29',
            'runtime' => 10,
            'tagline' => '',
            'title' => 'Taxi 3',
            'id'=> 200
        ]);
        $I->assertSame($movie->getId(), 200);
        $I->assertSame('Taxi 3', $movie->getTitle());
    }
}
