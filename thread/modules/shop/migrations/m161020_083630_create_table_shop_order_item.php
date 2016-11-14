<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_083630_create_table_shop_order_item
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_083630_create_table_shop_order_item extends Migration
{
    /**
     * @var string
     */
    public $tableOrderItem = '{{%shop_order_item}}';
    public $tableOrder = '{{%shop_order}}';

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
        $this->createTable($this->tableOrderItem, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'order_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with shop_order'),
            'product_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with catalog_product'),
            'count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Number of item'),
            'price' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Price item'",
            'discount_percent' =>  "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Percent Discount for item'",
            'discount_money' =>  "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Discount of money for item'",
            'discount_full' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Summ discount for item'",
            'summ' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Summ of items without discount for item'",
            'total_summ' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Total Summ of items with discount for item'",
            'extra_param' =>  $this->string(512)->notNull()->defaultValue('')->comment('extra_param'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableOrderItem, 'published');
        $this->createIndex('deleted', $this->tableOrderItem, 'deleted');
        $this->addForeignKey(
            'fk-shop_order_item-order_id-shop_order-id',
            $this->tableOrderItem,
            'order_id',
            $this->tableOrder,
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
        $this->dropIndex('fk-shop_order_item-order_id-shop_order-id', $this->tableOrderItem);
        $this->dropIndex('deleted', $this->tableOrderItem);
        $this->dropIndex('published', $this->tableOrderItem);
        $this->dropTable($this->tableOrderItem);
    }
}
