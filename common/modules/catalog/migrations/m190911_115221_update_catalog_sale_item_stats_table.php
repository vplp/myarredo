<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190911_115221_update_catalog_sale_item_stats_table extends Migration
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
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark'");
        $this->createIndex('mark', $this->table, 'mark');

        $this->renameColumn($this->table, 'sale_item_id', 'product_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'product_id', 'sale_item_id');

        $this->dropIndex('mark', $this->table);
        $this->dropColumn($this->table, 'mark');
    }
}
