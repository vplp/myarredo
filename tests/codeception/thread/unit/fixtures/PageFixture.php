<?php

namespace tests\codeception\thread\unit\fixtures;

use yii\test\ActiveFixture;
//
use thread\modules\page\models\Page;

/**
 * User fixture
 */
class PageFixture extends ActiveFixture
{
    public $modelClass = Page::class;
}
