<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m171208_124211_update_catalog_product_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item}}';

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
        $this->addColumn($this->table, 'in_stock', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'in_stock' after removed");
        $this->createIndex('in_stock', $this->table, 'in_stock');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('in_stock', $this->table);
        $this->dropColumn($this->table, 'in_stock');
    }
}
