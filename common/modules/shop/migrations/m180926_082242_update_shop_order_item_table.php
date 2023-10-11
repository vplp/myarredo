<?php

use yii\db\Migration;
use common\modules\shop\Shop as ShopModule;

class m180926_082242_update_shop_order_item_table extends Migration
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
        $this->createIndex('product_id', $this->table, 'product_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('product_id', $this->table);
    }
}
