<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

class m190925_104243_update_payment_table extends Migration
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
            "enum('factory_promotion','italian_item','italian_item_delivery', 'promotion_item', 'promotion_sale_item', 'promotion_italian_item') NOT NULL DEFAULT 'factory_promotion'"
        );

        $this->addColumn($this->table, 'promotion_package_id', $this->integer(11)->unsigned()->notNull()->after('type'));
        $this->createIndex('promotion_package_id', $this->table, 'promotion_package_id');
    }

    public function safeDown()
    {
        $this->dropIndex('promotion_package_id', $this->table);
        $this->dropColumn($this->table, 'promotion_package_id');

        $this->alterColumn(
            $this->table,
            'type',
            "enum('factory_promotion','italian_item','italian_item_delivery') NOT NULL DEFAULT 'factory_promotion'"
        );
    }
}
