<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_083457_create_table_shop_cart
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_083457_create_table_shop_cart extends Migration
{
    /**
     * @var string
     */
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
        $this->createTable($this->tableCart, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('User ID'),
            'php_session_id' =>  $this->string(30)->notNull()->comment('Session ID'),
            'items_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Number of items'),
            'items_total_count' => $this->integer(11)->notNull()->defaultValue(0)->comment('Summ count_item'),
            'items_summ' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Summ of items without discount for item'",
            'items_total_summ' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Total Summ of items with discount for item'",
            'discount_percent' =>  "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Percent Discount for order'",
            'discount_money' =>  "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Discount of money for order'",
            'discount_full' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Summ discount for order'",
            'total_summ' => "decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Summ of items with discount for order and items'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
             'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableCart, 'published');
        $this->createIndex('deleted', $this->tableCart, 'deleted');
        $this->createIndex('user_id', $this->tableCart, 'user_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('user_id', $this->tableCart);
        $this->dropIndex('deleted', $this->tableCart);
        $this->dropIndex('published', $this->tableCart);
        $this->dropTable($this->tableCart);
    }
}
