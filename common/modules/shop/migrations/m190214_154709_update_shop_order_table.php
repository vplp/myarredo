<?php

use yii\db\Migration;
use common\modules\shop\Shop;

class m190214_154709_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

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
        $this->addColumn(
            $this->table,
            'product_type',
            "enum('product','sale-italy') NOT NULL DEFAULT 'product' after id"
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'product_type');
    }
}
