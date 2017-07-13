<?php

use yii\db\Migration;

class m170506_105637_add_table_seo_info_data extends Migration
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_info}}';

    /**
     * Table lang table name
     *
     * @var string
     */
    public $tableLang = '{{%seo_info_lang}}';

    /**
     *
     */
    public function safeUp()
    {
        /** Insert table */
        $this->batchInsert(
            $this->table,
            [
                'id',
                'alias',
                'default_title',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'base-url',
                    'default_title' => 'base full url to site',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 2,
                    'alias' => 'web-site-logo',
                    'default_title' => 'full url to logo',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 3,
                    'alias' => 'web-site-name',
                    'default_title' => '',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 4,
                    'alias' => 'web-site-alternatename',
                    'default_title' => '',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 5,
                    'alias' => 'web-site-search-action',
                    'default_title' => '',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 6,
                    'alias' => 'web-site-telephone',
                    'default_title' => 'web site telephone +1-401-555-1212',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
            ]
        );

        /** Insert table lang */
        $this->batchInsert(
            $this->tableLang,
            [
                'rid',
                'lang',
                'title',
                'value',
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'base full url to site',
                    'value' => 'https://query.example.com',
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'full url to logo',
                    'value' => 'https://query.example.com/logo.png',
                ],
                [
                    'rid' => 3,
                    'lang' => 'en-EN',
                    'title' => 'web site name',
                    'value' => 'web site name',
                ],
                [
                    'rid' => 4,
                    'lang' => 'en-EN',
                    'title' => 'web site alternate name',
                    'value' => 'web site alternate name',
                ],
                [
                    'rid' => 5,
                    'lang' => 'en-EN',
                    'title' => 'https://query.example.com/search?q={search_term_string}',
                    'value' => 'https://query.example.com/search?q={search_term_string}',
                ],
                [
                    'rid' => 6,
                    'lang' => 'en-EN',
                    'title' => 'web site telephone +1-401-555-1212',
                    'value' => '+1-401-555-1212',
                ],
            ]
        );
    }
}
