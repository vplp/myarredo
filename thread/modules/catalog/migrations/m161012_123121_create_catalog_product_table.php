<?php

use yii\db\Migration;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class m161012_123121_create_catalog_product_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161012_123121_create_catalog_product_table extends Migration
{
    /**
     * Catalog product table name
     * @var string
     */
    public $tableProduct = '{{%catalog_product}}';

    /**
     *
     */
    public function init()
    {
        $this->db = CatalogModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableProduct,
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
                'image_link' => $this->string(255)->defaultValue(null)->comment('Image link'),
                'gallery_image' => $this->string(1024)->defaultValue(null)->comment('Gallery image'),
                'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
                'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
                'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
                'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
                'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
            ]
        );
        $this->createIndex('published', $this->tableProduct, 'published');
        $this->createIndex('deleted', $this->tableProduct, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableProduct);
        $this->dropIndex('published', $this->tableProduct);
        $this->dropTable($this->tableProduct);
    }
}
