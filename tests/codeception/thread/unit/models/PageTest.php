<?php

namespace tests\codeception\thread\unit\models;

use Yii;
use Codeception\Specify;
//
use thread\modules\page\models\{
    Page, PageLang
};
//
use tests\codeception\thread\unit\DbTestCase;
use tests\codeception\thread\unit\fixtures\{
    PageFixture, PageLangFixture
};

/**
 * Login form test
 */
class PageTest extends DbTestCase
{

    use Specify;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     *
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     *
     */
    public function testReadPage()
    {
        $page = Page::find()->alias('pageone')->one();
        $this->assertNotNull($page, 'Page not found');
    }

    /**
     *
     */
    public function testReadPageLang()
    {
        $page = PageLang::find()->where(['rid' => '1'])->one();
        $this->assertNotNull($page, 'Page not found');
    }


    /**
     *
     */
    public function testDropPage()
    {
        $page = Page::find()->alias('pageone')->one();
        $page->delete();
        //
        $page = Page::find()->alias('pageone')->one();
        $this->assertNull($page, 'Page has not been deleted');
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'page' => [
                'class' => PageFixture::class,
                'dataFile' => '@tests/codeception/thread/unit/fixtures/data/models/page.php'
            ],
            'pagelang' => [
                'class' => PageLangFixture::class,
                'dataFile' => '@tests/codeception/thread/unit/fixtures/data/models/pagelang.php'
            ],
        ];
    }
}
