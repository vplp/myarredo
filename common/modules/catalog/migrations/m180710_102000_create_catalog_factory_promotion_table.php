<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `catalog_factory_promotion`.
 */
class m180710_102000_create_catalog_factory_promotion_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_promotion}}';

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
            'count_of_months' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'daily_budget' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'cost' => "decimal(10,2) NOT NULL DEFAULT '0.00'",
            'status' => "enum('0','1') NOT NULL DEFAULT '0'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('idx-user_id', $this->table, 'user_id');
        $this->createIndex('status', $this->table, 'status');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('status', $this->table);
        $this->dropIndex('idx-user_id', $this->table);

        $this->dropTable($this->table);
    }
}
