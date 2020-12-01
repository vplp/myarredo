<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m201201_141403_update_shop_order_item_price_table extends Migration
{

    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order_item_price}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'currency', "enum('EUR','RUB', 'USD') NOT NULL DEFAULT 'EUR' AFTER price");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'currency');
    }
}
