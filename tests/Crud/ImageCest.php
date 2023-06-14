<?php

namespace Tests\Crud;

use Entity\Cover;
use Entity\Exception\EntityNotFoundException;
use Entity\Image;
use Tests\CrudTester;

class ImageCest
{
    public function findImgageById(CrudTester $I)
    {
        $cover = Image::findById(16731);
        $I->assertSame(16731, $cover->getId());
        $I->assertSame(file_get_contents(codecept_data_dir() . '/img/imgPeople.jpg'), $cover->getJpeg());
    }
    public function findImageByIdThrowsExceptionIfImageDoesNotExist(CrudTester $I)
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Image::findById(PHP_INT_MAX);
        });
    }
}
