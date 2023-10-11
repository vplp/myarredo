<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_sale_item_stats_days}}`.
 */
class m190911_113030_create_catalog_sale_item_stats_days_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item_stats_days}}';

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
            'product_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'factory_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'views' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'requests' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'date' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-product_id', $this->table, 'product_id');
        $this->createIndex('idx-factory_id', $this->table, 'factory_id');
        $this->createIndex('idx-country_id', $this->table, 'country_id');
        $this->createIndex('idx-city_id', $this->table, 'city_id');
        $this->createIndex('idx-views', $this->table, 'views');
        $this->createIndex('idx-requests', $this->table, 'requests');
        $this->createIndex('idx-date', $this->table, 'date');
        $this->createIndex('idx-updated_at', $this->table, 'updated_at');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('idx-product_id', $this->table);
        $this->dropIndex('idx-factory_id', $this->table);
        $this->dropIndex('idx-country_id', $this->table);
        $this->dropIndex('idx-city_id', $this->table);
        $this->dropIndex('idx-views', $this->table);
        $this->dropIndex('idx-requests', $this->table);
        $this->dropIndex('idx-date', $this->table);
        $this->dropIndex('idx-updated_at', $this->table);

        $this->dropTable($this->table);
    }
}
