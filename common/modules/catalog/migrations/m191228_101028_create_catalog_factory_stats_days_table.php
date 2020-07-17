<?php

use yii\db\Migration;
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_factory_stats_days}}`.
 */
class m191228_101028_create_catalog_factory_stats_days_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_stats_days}}';

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
            'factory_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'views' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'requests' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'date' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('factory_id', $this->table, 'factory_id');
        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('city_id', $this->table, 'city_id');
        $this->createIndex('views', $this->table, 'views');
        $this->createIndex('requests', $this->table, 'requests');
        $this->createIndex('date', $this->table, 'date');
        $this->createIndex('updated_at', $this->table, 'updated_at');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('factory_id', $this->table);
        $this->dropIndex('country_id', $this->table);
        $this->dropIndex('city_id', $this->table);
        $this->dropIndex('views', $this->table);
        $this->dropIndex('requests', $this->table);
        $this->dropIndex('date', $this->table);
        $this->dropIndex('updated_at', $this->table);

        $this->dropTable($this->table);
    }
}
