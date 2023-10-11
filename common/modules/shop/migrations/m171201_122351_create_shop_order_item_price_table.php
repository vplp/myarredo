<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m171201_122351_create_shop_order_item_price_table extends Migration
{
    /**
     * @var string
     */
    public $tableOrderItemPrice = '{{%shop_order_item_price}}';
    public $tableOrderItem = '{{%shop_order_item}}';
    public $tableOrder = '{{%shop_order}}';
    public $tableUser = '{{%user}}';

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
        $this->createTable($this->tableOrderItemPrice, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'order_id' => $this->integer(11)->unsigned()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'product_id' => $this->integer(11)->unsigned()->notNull(),
            'price' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Price item'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);

        $this->addForeignKey(
            'fk-shop_order_item_price-order_id-shop_order-id',
            $this->tableOrderItemPrice,
            'order_id',
            $this->tableOrder,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-shop_order_item_price-user_id-user-id',
            $this->tableOrderItemPrice,
            'user_id',
            $this->tableUser,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-shop_order_item_price-user_id-user-id', $this->tableOrderItemPrice);
        $this->dropForeignKey('fk-shop_order_item_price-order_id-shop_order-id', $this->tableOrderItemPrice);

        $this->dropTable($this->tableOrderItemPrice);
    }
}
