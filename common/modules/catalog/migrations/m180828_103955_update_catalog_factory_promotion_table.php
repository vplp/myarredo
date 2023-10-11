<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m180828_103955_update_catalog_factory_promotion_table
 */
class m180828_103955_update_catalog_factory_promotion_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_promotion}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'invoice_id',
            $this->string(255)->defaultValue(null)->after('user_id')
        );

        $this->createIndex('idx-invoice_id', $this->table, 'invoice_id');

        $this->renameColumn($this->table, 'cost', 'amount');

        $this->addColumn(
            $this->table,
            'payment_status',
            "enum('new','paid') NOT NULL DEFAULT 'new' after status"
        );
    }

    public function safeDown()
    {
        $this->renameColumn($this->table, 'amount', 'cost');

        $this->dropIndex('idx-invoice_id', $this->table);

        $this->dropColumn($this->table, 'invoice_id');
        $this->dropColumn($this->table, 'payment_status');
    }
}
