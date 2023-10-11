<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m190604_122932_add_indexes_for_shop_tables extends Migration
{
    // CartItem
    public $tableCartItem = '{{%shop_cart_item}}';

    // Order
    public $tableOrder = '{{%shop_order}}';

    // OrderAnswer
    public $tableOrderAnswer = '{{%shop_order_answer}}';

    // OrderItem
    public $tableOrderItem = '{{%shop_order_item}}';

    // OrderItemPrice
    public $tableOrderItemPrice = '{{%shop_order_item_price}}';

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
        // CartItem
        $this->createIndex('product_id', $this->tableCartItem, 'product_id');

        // Order
        $this->createIndex('product_type', $this->tableOrder, 'product_type');
        $this->createIndex('lang', $this->tableOrder, 'lang');
        $this->createIndex('delivery_method_id', $this->tableOrder, 'delivery_method_id');
        $this->createIndex('payment_method_id', $this->tableOrder, 'payment_method_id');
        $this->createIndex('order_status', $this->tableOrder, 'order_status');
        $this->createIndex('payd_status', $this->tableOrder, 'payd_status');
        $this->createIndex('updated_at', $this->tableOrder, 'updated_at');

        // OrderAnswer
        $this->createIndex('answer_time', $this->tableOrderAnswer, 'answer_time');
        $this->createIndex('updated_at', $this->tableOrderAnswer, 'updated_at');

        // OrderItem
        $this->createIndex('price', $this->tableOrderItem, 'price');
        $this->createIndex('updated_at', $this->tableOrderItem, 'updated_at');

        // OrderItemPrice
        $this->createIndex('price', $this->tableOrderItemPrice, 'price');
        $this->createIndex('updated_at', $this->tableOrderItemPrice, 'updated_at');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        // CartItem
        $this->dropIndex('product_id', $this->tableCartItem);

        // Order
        $this->dropIndex('product_type', $this->tableOrder);
        $this->dropIndex('lang', $this->tableOrder);
        $this->dropIndex('delivery_method_id', $this->tableOrder);
        $this->dropIndex('payment_method_id', $this->tableOrder);
        $this->dropIndex('order_status', $this->tableOrder);
        $this->dropIndex('payd_status', $this->tableOrder);
        $this->dropIndex('updated_at', $this->tableOrder);

        // OrderAnswer
        $this->dropIndex('answer_time', $this->tableOrderAnswer);
        $this->dropIndex('updated_at', $this->tableOrderAnswer);

        // OrderItem
        $this->dropIndex('price', $this->tableOrderItem);
        $this->dropIndex('updated_at', $this->tableOrderItem);

        // OrderItemPrice
        $this->dropIndex('price', $this->tableOrderItemPrice);
        $this->dropIndex('updated_at', $this->tableOrderItemPrice);
    }
}
