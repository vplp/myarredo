<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Handles the creation of table `{{%catalog_italian_item_stats}}`.
 */
class m190409_112121_create_catalog_italian_item_stats_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item_stats}}';

    /**
     * table name
     * @var string
     */
    public $tableItalian = '{{%catalog_italian_item}}';

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
            'item_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'country_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'city_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'ip' => $this->string(45)->notNull(),
            'http_user_agent' => $this->string(512)->notNull(),
            'is_bot' => "enum('0','1') NOT NULL DEFAULT '0'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('user_id', $this->table, 'user_id');
        $this->createIndex('item_id', $this->table, 'item_id');
        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('city_id', $this->table, 'city_id');

        $this->addForeignKey(
            'fk-catalog_italian_item_stats_rel_catalog_italian_item_id_fk1',
            $this->table,
            'item_id',
            $this->tableItalian,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-catalog_italian_item_stats_rel_catalog_italian_item_id_fk1', $this->table);

        $this->dropIndex('user_id', $this->table);
        $this->dropIndex('item_id', $this->table);
        $this->dropIndex('country_id', $this->table);
        $this->dropIndex('city_id', $this->table);

        $this->dropTable($this->table);
    }
}
