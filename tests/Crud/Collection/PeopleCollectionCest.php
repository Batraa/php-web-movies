<?php

namespace Tests\Crud\Collection;

use Entity\Collection\PeopleCollection;
use Entity\Movie;
use Entity\People;
use Tests\CrudTester;

class PeopleCollectionCest
{
    public function findByMovieId(CrudTester $I)
    {
        $expectedPeoples = [
            ['id' => 1256603,'avatarId' => 3675, 'birthday' => '1991-06-26', 'deathday' => null,'name' => 'Natsuki Hanae','biography' => '','placeOfBirth' => 'Kanagawa Prefecture, Japan'],
            ['id' => 1563442,'avatarId' => 3676,'birthday' => '1994-10-16','deathday' => null,'name' => 'Akari Kito','biography' => '','placeOfBirth' => 'Aichi Prefecture, Japan']
        ];


        $peoples = PeopleCollection::findByMovieId(895006);
        $I->assertCount(count($expectedPeoples), $peoples);
        $I->assertContainsOnlyInstancesOf(People::class, $peoples);
        foreach ($peoples as $index => $people) {
            $expectedPeople = $expectedPeoples[$index];
            $I->assertEquals($expectedPeople['id'], $people->getId());
            $I->assertEquals($expectedPeople['avatarId'], $people->getAvatarId());
            $I->assertEquals($expectedPeople['birthday'], $people->getBirthday());
            $I->assertEquals($expectedPeople['deathday'], $people->getDeathday());
            $I->assertEquals($expectedPeople['name'], $people->getName());
            $I->assertEquals($expectedPeople['biography'], $people->getBiography());
            $I->assertEquals($expectedPeople['placeOfBirth'], $people->getPlaceOfBirth());
        }
    }
}
