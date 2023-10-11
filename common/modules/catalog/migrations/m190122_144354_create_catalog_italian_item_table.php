<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_italian_item`.
 */
class m190122_144354_create_catalog_italian_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(32)->notNull()->unique(),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'region' => $this->string(255)->defaultValue(null),
            'phone' => $this->string(255)->defaultValue(null),
            'email' => $this->string(255)->defaultValue(null),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'catalog_type_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'factory_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'factory_name' => $this->string(255)->defaultValue(null),
            'article' => $this->string(255)->defaultValue(null),
            'image_link' => $this->string(255)->defaultValue(null),
            'gallery_image' => $this->string(1024)->defaultValue(null),
            'price' => $this->float()->defaultValue(0.00),
            'price_new' => $this->float()->defaultValue(0.00),
            'currency' => "enum('EUR','RUB') NOT NULL DEFAULT 'EUR'",
            'volume' => $this->float()->defaultValue(0),
            'position' => $this->integer(11)->unsigned()->defaultValue(0),
            'on_main' => "enum('0','1') NOT NULL DEFAULT '0'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('idx-country_id', $this->table, 'country_id');
        $this->createIndex('idx-city_id', $this->table, 'city_id');
        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('idx-catalog_type_id', $this->table, 'catalog_type_id');
        $this->createIndex('idx-factory_id', $this->table, 'factory_id');
        $this->createIndex('idx-position', $this->table, 'position');
        $this->createIndex('idx-published', $this->table, 'published');
        $this->createIndex('idx-deleted', $this->table, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('idx-deleted', $this->table);
        $this->dropIndex('idx-published', $this->table);
        $this->dropIndex('idx-position', $this->table);
        $this->dropIndex('idx-factory_id', $this->table);
        $this->dropIndex('idx-catalog_type_id', $this->table);
        $this->dropIndex('idx-user_id', $this->table);
        $this->dropIndex('idx-city_id', $this->table);
        $this->dropIndex('idx-country_id', $this->table);

        $this->dropTable($this->table);
    }
}
