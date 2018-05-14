<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_sale_stats`.
 */
class m180514_091301_create_catalog_sale_stats_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item_stats}}';

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
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'sale_item_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'date' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('idx-sale_item_id', $this->table, 'sale_item_id');
        $this->createIndex('idx-country_id', $this->table, 'country_id');
        $this->createIndex('idx-city_id', $this->table, 'city_id');
        $this->createIndex('idx-date', $this->table, 'date');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user_id', $this->table);
        $this->dropIndex('idx-sale_item_id', $this->table);
        $this->dropIndex('idx-country_id', $this->table);
        $this->dropIndex('idx-city_id', $this->table);
        $this->dropIndex('idx-date', $this->table);

        $this->dropTable($this->table);
    }
}
