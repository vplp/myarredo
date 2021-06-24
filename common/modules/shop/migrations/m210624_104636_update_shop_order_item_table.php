<?php

use yii\db\Migration;
use common\modules\shop\Shop as ShopModule;

class m210624_104636_update_shop_cart_item_table extends Migration
{

    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_cart_item}}';

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
        $this->createIndex('cart_id_product_id', $this->table, ['cart_id', 'product_id'], true);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('cart_id_product_id', $this->table);
    }
}
