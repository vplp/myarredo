<?php

use yii\db\Migration;
//
use thread\modules\catalog\Catalog as CatalogModule;

/**
 * Class m161012_111141_create_catalog_group_table
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class m161012_111141_create_catalog_group_table extends Migration
{
    /**
     * Catalog group table name
     * @var string
     */
    public $tableGroup = '{{%catalog_group}}';

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
        $this->createTable($this->tableGroup, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'parent_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Parent ID'),
            'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'image_link' => $this->string(255)->defaultValue(null)->comment('Image link'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('parent_id', $this->tableGroup, 'parent_id');
        $this->createIndex('published', $this->tableGroup, 'published');
        $this->createIndex('deleted', $this->tableGroup, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {

        $this->dropIndex('deleted', $this->tableGroup);
        $this->dropIndex('published', $this->tableGroup);
        $this->dropIndex('parent_id', $this->tableGroup);
        $this->dropTable($this->tableGroup);
    }
}