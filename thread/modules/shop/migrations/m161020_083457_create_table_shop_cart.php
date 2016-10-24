<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

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

            'items_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Summ of items without discount for item'),
            'items_total_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Total Summ of items with discount for item'),
            'discount_percent' =>  $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Percent Discount for order'),
            'discount_money' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Discount of money for order'),
            'discount_full' => $this->float(15,3)->notNull()->defaultValue(0)->comment('Summ discount for order'),
            'total_summ' => $this->float(15,3)->notNull()->defaultValue(0.000)->comment('Summ of items with discount for order and items'),

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
