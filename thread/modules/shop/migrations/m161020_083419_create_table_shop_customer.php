<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_083419_create_table_shop_customer
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_083419_create_table_shop_customer extends Migration
{
    /**
     * @var string
     */
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
        $this->createTable($this->tableCustomer, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('User ID'),
            'email' => $this->string(255)->notNull()->comment('Email'),
            'phone' => $this->string(50)->notNull()->comment('Phone'),
            'full_name' => $this->string(255)->notNull()->comment('full_name'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableCustomer, 'published');
        $this->createIndex('deleted', $this->tableCustomer, 'deleted');
        $this->createIndex('user_id', $this->tableCustomer, 'user_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('user_id', $this->tableCustomer);
        $this->dropIndex('deleted', $this->tableCustomer);
        $this->dropIndex('published', $this->tableCustomer);
        $this->dropTable($this->tableCustomer);
    }
}
