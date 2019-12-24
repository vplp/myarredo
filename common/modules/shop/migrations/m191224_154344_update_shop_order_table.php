<?php

use yii\db\Migration;
//
use common\modules\shop\Shop;

class m191224_154344_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Shop::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'mark1', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark' AFTER mark");
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
