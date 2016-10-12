<?php

use yii\db\Migration;

/**
 * Class m161012_123121_create_catalog_product_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161012_131146_insert_default_catalog extends Migration
{
    /**
     * Catalog group table name
     * @var string
     */
    public $tableGroup = '{{%catalog_group}}';

    /**
     * Catalog group language table name
     * @var string
     */
    public $tableGroupLang = '{{%catalog_group_lang}}';

    /**
     * Catalog product table name
     * @var string
     */
    public $tableProduct = '{{%catalog_product}}';

    /**
     * Catalog product language table name
     * @var string
     */
    public $tableProductLang = '{{%catalog_product_lang}}';

    /**
     * Menu item language table name
     * @var string
     */
    public $tableMenuItemLang = '{{%menu_item_lang}}';

    /**
     *
     */
    public function safeUp()
    {
        /** Insert catalog_group */
        $this->batchInsert(
            $this->tableGroup,
            [
                'id',
                'parent_id',
                'alias',
                'image_link',
                'position',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'parent_id' => 0,
                    'alias' => 'group1',
                    'image_link' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 2,
                    'parent_id' => 1,
                    'alias' => 'group2',
                    'image_link' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 3,
                    'parent_id' => 2,
                    'alias' => 'group3',
                    'image_link' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 4,
                    'parent_id' => 0,
                    'alias' => 'group4',
                    'image_link' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
            ]
        );

        /** Insert catalog_group_lang */
        $this->batchInsert(
            $this->tableGroupLang,
            [
                'rid',
                'lang',
                'title',
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'Group 1',
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'Group 2',
                ],
                [
                    'rid' => 3,
                    'lang' => 'en-EN',
                    'title' => 'Group 3',
                ],
                [
                    'rid' => 4,
                    'lang' => 'en-EN',
                    'title' => 'Group 4',
                ],
            ]
        );

        /** Insert catalog_product */
        $this->batchInsert(
            $this->tableProduct,
            [
                'id',
                'alias',
                'image_link',
                'gallery_image',
                'position',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'product1',
                    'image_link' => null,
                    'gallery_image' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 2,
                    'alias' => 'product2',
                    'image_link' => null,
                    'gallery_image' => null,
                    'position' => 0,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
            ]
        );

        /** Insert catalog_product_lang */
        $this->batchInsert(
            $this->tableProductLang,
            [
                'rid',
                'lang',
                'title',
                'description',
                'content'
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'Product 1',
                    'description' => 'Product 1 description',
                    'content' => 'Product 1 content',
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'Product 2',
                    'description' => 'Product 2 description',
                    'content' => 'Product 2 content',
                ],
            ]
        );
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableProductLang);
        $this->dropForeignKey('fk-catalog_product_lang-rid-catalog_product-id', $this->tableProductLang);

        $this->truncateTable($this->tableGroupLang);
        $this->dropForeignKey('fk-catalog_group_lang-rid-catalog_group-id', $this->tableGroupLang);

        $this->truncateTable($this->tableGroup);

        $this->addForeignKey(
            'fk-catalog_product_lang-rid-catalog_product-id',
            $this->tableProductLang,
            'rid',
            $this->tableProduct,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-catalog_group_lang-rid-catalog_group-id',
            $this->tableGroupLang,
            'rid',
            $this->tableGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}