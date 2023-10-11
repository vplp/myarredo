<?php

use yii\db\Migration;
//
use common\modules\payment\PaymentModule;

/**
 * Class m190319_112338_create_payment_rel_item_table
 */
class m190327_172338_update_payment_rel_item_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%payment_rel_item}}';

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
        $this->dropIndex('idx_payment_id_item_id', $this->tableRel);

        $this->addPrimaryKey('idx_payment_id_item_id', $this->tableRel, ['payment_id', 'item_id']);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('idx_payment_id_item_id', $this->tableRel);

        $this->createIndex('idx_payment_id_item_id', $this->tableRel, ['payment_id', 'item_id'], true);
    }
}
