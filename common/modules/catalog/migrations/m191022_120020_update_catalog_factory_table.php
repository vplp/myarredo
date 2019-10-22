<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191022_120020_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn($this->table, 'show_for_com', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_ua");
        $this->createIndex('show_for_com', $this->table, 'show_for_com');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'show_for_com');
        $this->dropIndex('show_for_com', $this->table);
    }
}
