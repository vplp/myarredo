<?php

use thread\modules\shop\Shop;
use yii\db\Migration;

/**
 * Class m161020_105154_create_table_shop_delivery_methods
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161020_105154_create_table_shop_delivery_methods extends Migration
{
    /**
     * @var string
     */
    public $tableDeliveryMethods = '{{%shop_delivery_methods}}';


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
        $this->createTable($this->tableDeliveryMethods, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            //'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",

        ]);
        $this->createIndex('published', $this->tableDeliveryMethods, 'published');
        $this->createIndex('deleted', $this->tableDeliveryMethods, 'deleted');
        
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableDeliveryMethods);
        $this->dropIndex('published', $this->tableDeliveryMethods);
        $this->dropTable($this->tableDeliveryMethods);
    }
}
