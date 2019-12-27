<?php

use yii\db\Migration;
//
use common\modules\shop\Shop as ShopModule;

class m191226_145712_update_shop_order_item_price_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order_item_price}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = ShopModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'out_of_production', "enum('0','1') NOT NULL DEFAULT '0' AFTER price");
        $this->createIndex('out_of_production', $this->table, 'out_of_production');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('out_of_production', $this->table);
        $this->dropColumn($this->table, 'out_of_production');
    }
}
