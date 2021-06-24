<?php

use yii\db\Migration;
use common\modules\shop\Shop as ShopModule;

class m210624_103136_update_shop_order_item_table extends Migration
{

    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order_item}}';

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
        $this->createIndex('order_id_product_id', $this->table, ['order_id', 'product_id'], true);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('order_id_product_id', $this->table);
    }
}
