<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

class m200115_155324_update_payment_table extends Migration
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
            "enum('factory_promotion','italian_item','italian_item_delivery','promotion_item','promotion_sale_item','promotion_italian_item','tariffs') NOT NULL DEFAULT 'factory_promotion'"
        );

        $this->addColumn($this->table, 'tariffs', $this->string(1024)->defaultValue(null)->after('type'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'tariffs');

        $this->alterColumn(
            $this->table,
            'type',
            "enum('factory_promotion','italian_item','italian_item_delivery','promotion_item','promotion_sale_item','promotion_italian_item') NOT NULL DEFAULT 'factory_promotion'"
        );
    }
}
