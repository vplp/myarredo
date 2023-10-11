<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m171213_132454_create_catalog_product_stats_table
 */
class m171213_132454_create_catalog_product_stats_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item_stats}}';

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
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'product_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
