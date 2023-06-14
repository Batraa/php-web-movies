<?php

namespace Tests\Crud;

use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Tests\CrudTester;

class PeopleCest
{
    public function findById(CrudTester $I)
    {
        $people = People::findById(1145);
        $I->assertSame(1145, $people->getId());
        $I->assertSame('Zbigniew Zamachowski', $people->getName());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            People::findById(PHP_INT_MAX);
        });
    }
}
