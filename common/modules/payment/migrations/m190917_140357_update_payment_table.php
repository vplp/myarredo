<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

class m190917_140357_update_payment_table extends Migration
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

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'change_tariff', "enum('0','1') NOT NULL DEFAULT '0' AFTER type");
        $this->createIndex('change_tariff', $this->table, 'change_tariff');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('change_tariff', $this->table);
        $this->dropColumn($this->table, 'change_tariff');
    }
}
