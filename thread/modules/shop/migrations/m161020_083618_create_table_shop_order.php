<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

class m161020_083618_create_table_shop_order extends Migration
{

    /**
     * @var string
     */
    public $tableOrder = '{{%shop_order}}';

    public $tableCustomer = '{{%shop_customer}}';

    /**
     *
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
        $this->createTable($this->tableOrder, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'customer_id' => $this->integer(11)->unsigned()->notNull()->comment('Customer ID'),
            'manager_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Manager ID'),
            'delivery_method_id' => $this->integer(11)->unsigned()->notNull()->comment('delivery_method ID'),
            'delivery_price' => $this->float(15,3)->unsigned()->notNull()->comment('Price delivery'),
            'payment_method_id' => $this->integer(11)->unsigned()->notNull()->comment('payment_method ID'),
            'order_status' => "enum('new','confirmed','on_performance','prepared','on_delivery','refusal','executed') NOT NULL DEFAULT 'new' COMMENT 'Status of Order'",
            'payd_status' => "enum('billed', 'not_paid', 'paid_up') NOT NULL DEFAULT 'not_paid' COMMENT 'Status payment'",
            'items_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Number of items'),
            'items_total_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Summ count_item'),
            'items_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Summ of items without discount for item'),
            'items_total_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Total Summ of items with discount for item'),
            'discount_percent' =>  $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Percent Discount for order'),
            'discount_money' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Discount of money for order'),
            'discount_full' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Summ discount for order'),
            'total_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Summ of items without discount for order and items'),
            'comment' =>  $this->string(512)->notNull()->defaultValue('')->comment('Comment'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableOrder, 'published');
        $this->createIndex('deleted', $this->tableOrder, 'deleted');
        $this->addForeignKey(
            'fk-shop_order-customer_id-shop_customer-id',
            $this->tableOrder,
            'customer_id',
            $this->tableCustomer,
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
        $this->dropIndex('fk-shop_order-customer_id-shop_customer-id', $this->tableOrder);
        $this->dropIndex('deleted', $this->tableOrder);
        $this->dropIndex('published', $this->tableOrder);
        $this->dropTable($this->tableOrder);
    }
}
