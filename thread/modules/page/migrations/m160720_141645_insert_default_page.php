<?php

use yii\db\Migration;
use backend\modules\page\Page;

/**
 * Class m160720_141645_insert_default_page
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160720_141645_insert_default_page extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%page}}';

    /**
     * Language Page table name
     * @var string
     */
    public $tablePageLang = '{{%page_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Page::getDb();
        parent::init();
    }

    public function safeUp()
    {
        /** Insert page */
        $this->batchInsert(
            $this->tablePage,
            [
                'id',
                'alias',
                'image_link',
                'created_at',
                'updated_at',
                'published',
                'deleted'
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'about',
                    'image_link' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
                [
                    'id' => 2,
                    'alias' => 'privacy-policy',
                    'image_link' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
                [
                    'id' => 3,
                    'alias' => 'contacts',
                    'image_link' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
                [
                    'id' => 4,
                    'alias' => 'license-agreement',
                    'image_link' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
                [
                    'id' => 5,
                    'alias' => 'certificates',
                    'image_link' => null,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => 1,
                    'deleted' => 0,
                ],
            ]
        );

        /** Insert page_lang */
        $this->batchInsert(
            $this->tablePageLang,
            [
                'rid',
                'lang',
                'title',
                'content'
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'About us',
                    'content' => 'About us'
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'Privacy policy',
                    'content' => 'Privacy policy content'
                ],
                [
                    'rid' => 3,
                    'lang' => 'en-EN',
                    'title' => 'Contact us',
                    'content' => 'Contact us content'
                ],
                [
                    'rid' => 4,
                    'lang' => 'en-EN',
                    'title' => 'License agreement',
                    'content' => 'license-agreement content'
                ],
                [
                    'rid' => 5,
                    'lang' => 'en-EN',
                    'title' => 'Certificates',
                    'content' => 'Certificates content'
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->truncateTable($this->tablePageLang);
        $this->dropForeignKey('fk-page_lang-rid-page-id', $this->tablePageLang);

        $this->truncateTable($this->tablePage);

        $this->addForeignKey(
            'fk-page_lang-rid-page-id',
            $this->tablePageLang,
            'rid',
            $this->tablePage,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}
