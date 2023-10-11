<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_105218_create_table_shop_payment_methods
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_105218_create_table_shop_payment_methods extends Migration
{
    /**
     * @var string
     */
    public $tablePaymentMethods = '{{%shop_payment_methods}}';


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
        $this->createTable($this->tablePaymentMethods, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            //'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tablePaymentMethods, 'published');
        $this->createIndex('deleted', $this->tablePaymentMethods, 'deleted');

    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tablePaymentMethods);
        $this->dropIndex('published', $this->tablePaymentMethods);
        $this->dropTable($this->tablePaymentMethods);
    }
}
