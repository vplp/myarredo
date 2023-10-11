<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

class m190806_145053_update_payment_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%payment}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = PaymentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->alterColumn(
            $this->table,
            'type',
            "enum('factory_promotion','italian_item','italian_item_delivery') NOT NULL DEFAULT 'factory_promotion'"
        );
    }

    public function safeDown()
    {
        $this->alterColumn(
            $this->table,
            'type',
            "enum('factory_promotion','italian_item') NOT NULL DEFAULT 'factory_promotion'"
        );
    }
}
