<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

class m161020_083556_create_table_shop_cart_item extends Migration
{
    /**
     * @var string
     */
    public $tableCartItem = '{{%shop_cart_item}}';
    public $tableCart = '{{%shop_cart}}';

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
        $this->createTable($this->tableCartItem, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'cart_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with shop_cart'),
            'product_id' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID with catalog_product'),
            'count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Number of item'),
            'price' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Price item'),
            'discount_percent' =>  $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Percent Discount for item'),
            'discount_money' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Discount of money for item'),
            'discount_full' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Summ discount for item'),
            'summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Summ of items without discount for item'),
            'total_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Total Summ of items with discount for item'),
            'extra_param' =>  $this->string(512)->notNull()->defaultValue('')->comment('extra_param'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableCartItem, 'published');
        $this->createIndex('deleted', $this->tableCartItem, 'deleted');
        $this->addForeignKey(
            'fk-shop_cart_item-cart_id-shop_cart-id',
            $this->tableCartItem,
            'cart_id',
            $this->tableCart,
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
        $this->dropIndex('fk-shop_cart_item-cart_id-shop_cart-id', $this->tableCartItem);
        $this->dropIndex('deleted', $this->tableCartItem);
        $this->dropIndex('published', $this->tableCartItem);
        $this->dropTable($this->tableCartItem);
    }
}
