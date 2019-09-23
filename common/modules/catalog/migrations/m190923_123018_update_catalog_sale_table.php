<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190923_123018_update_catalog_sale_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item}}';

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
        $this->addColumn($this->table, 'mark1', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark1' AFTER mark");
        $this->createIndex('mark1', $this->table, 'mark1');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('mark1', $this->table);
        $this->dropColumn($this->table, 'mark1');
    }
}
