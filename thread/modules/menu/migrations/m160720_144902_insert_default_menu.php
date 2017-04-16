<?php

use yii\db\Migration;

/**
 * Class m160720_144902_insert_default_menu
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160720_144902_insert_default_menu extends Migration
{
    /**
     * Menu table name
     * @var string
     */
    public $tableMenu = '{{%menu}}';

    /**
     * Menu language table name
     * @var string
     */
    public $tableMenuLang = '{{%menu_lang}}';

    /**
     * Menu item table name
     * @var string
     */
    public $tableMenuItem = '{{%menu_item}}';

    /**
     * Menu item language table name
     * @var string
     */
    public $tableMenuItemLang = '{{%menu_item_lang}}';

    public function safeUp()
    {
        /** Insert menu */
        $this->batchInsert(
            $this->tableMenu,
            [
                'id',
                'alias',
                'created_at',
                'updated_at',
                'published',
                'deleted',
                'readonly'
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'header',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'readonly' => '0'
                ],
                [
                    'id' => 2,
                    'alias' => 'footer',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'readonly' => '0'
                ],
            ]
        );

        /** Insert menu_lang */
        $this->batchInsert(
            $this->tableMenuLang,
            [
               'rid',
                'lang',
                'title'
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'header',
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'footer',
                ],
            ]
        );

        /** Insert menu_item */
        $this->batchInsert(
            $this->tableMenuItem,
            [
                'id',
                'group_id',
                'type',
                'link',
                'position',
                'created_at',
                'updated_at',
                'published',
                'deleted',
                'link_type',
                'link_target',
                'internal_source',
                'internal_source_id',
                'parent_id'
            ],
            [
                [
                    'id' => 1,
                    'group_id' => 1,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 3,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 1,
                    'parent_id' => 0
                ],
                [
                    'id' => 2,
                    'group_id' => 2,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 2,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 2,
                    'parent_id' => 0
                ],
                [
                    'id' => 3,
                    'group_id' => 1,
                    'type' => 'normal',
                    'link' => 'faq',
                    'position' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'external',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 0,
                    'parent_id' => 0
                ],
                [
                    'id' => 4,
                    'group_id' => 1,
                    'type' => 'normal',
                    'link' => 'brands',
                    'position' => 2,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'external',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 0,
                    'parent_id' => 0
                ],
                [
                    'id' => 5,
                    'group_id' => 1,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 4,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 3,
                    'parent_id' => 0
                ],
                [
                    'id' => 6,
                    'group_id' => 2,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 1,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 3,
                    'parent_id' => 0
                ],
                [
                    'id' => 7,
                    'group_id' => 2,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 3,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 4,
                    'parent_id' => 0
                ],
                [
                    'id' => 8,
                    'group_id' => 2,
                    'type' => 'normal',
                    'link' => 'sitemap',
                    'position' => 4,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'external',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 0,
                    'parent_id' => 0
                ],
                [
                    'id' => 9,
                    'group_id' => 2,
                    'type' => 'normal',
                    'link' => '',
                    'position' => 5,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                    'link_type' => 'internal',
                    'link_target' => '_self',
                    'internal_source' => 'page',
                    'internal_source_id' => 5,
                    'parent_id' => 0
                ],
            ]
        );

        /** Insert menu_item_lang */
        $this->batchInsert(
            $this->tableMenuItemLang,
            [
                'rid',
                'lang',
                'title'
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'About us',
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'Privacy policy',
                ],
                [
                    'rid' => 3,
                    'lang' => 'en-EN',
                    'title' => 'Faq',
                ],
                [
                    'rid' => 4,
                    'lang' => 'en-EN',
                    'title' => 'Brands',
                ],
                [
                    'rid' => 5,
                    'lang' => 'en-EN',
                    'title' => 'Contact us',
                ],
                [
                    'rid' => 6,
                    'lang' => 'en-EN',
                    'title' => 'Contact us',
                ],
                [
                    'rid' => 7,
                    'lang' => 'en-EN',
                    'title' => 'License agreement',
                ],
                [
                    'rid' => 8,
                    'lang' => 'en-EN',
                    'title' => 'Site map',
                ],
                [
                    'rid' => 9,
                    'lang' => 'en-EN',
                    'title' => 'Certificates',
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->truncateTable($this->tableMenuItemLang);
        $this->dropForeignKey('fk-menu_item_lang-rid-menu_item-id', $this->tableMenuItemLang);

        $this->truncateTable($this->tableMenuItem);
        $this->dropForeignKey('fk-menu_item-rid-menu-id', $this->tableMenuItem);

        $this->truncateTable($this->tableMenuLang);
        $this->dropForeignKey('fk-menu_lang-rid-menu-id', $this->tableMenuLang);

        $this->truncateTable($this->tableMenu);

        $this->addForeignKey(
            'fk-menu_lang-rid-menu-id',
            $this->tableMenuLang,
            'rid',
            $this->tableMenu,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item-rid-menu-id',
            $this->tableMenuItem,
            'group_id',
            $this->tableMenu,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item_lang-rid-menu_item-id',
            $this->tableMenuItemLang,
            'rid',
            $this->tableMenuItem,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}
