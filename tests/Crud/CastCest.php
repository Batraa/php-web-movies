<?php

namespace Tests;

use Entity\Cast;
use Entity\Exception\EntityNotFoundException;
use Tests\CrudTester;

class CastCest
{
    public function getByMovieIdAndPeopleId(CrudTester $I)
    {
        $cast = Cast::getByMovieIdAndPeopleId(108, 1145);
        $I->assertSame(13367, $cast->getId());

    }

    public function getByMovieIdAndPeopleIdThrowsExceptionIfMovieDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Cast::getByMovieIdAndPeopleId(PHP_INT_MAX, 1145);
        });
    }

    public function getByMovieIdAndPeopleIdThrowsExceptionIPeopleDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Cast::getByMovieIdAndPeopleId(108, PHP_INT_MAX);
        });
    }
}
