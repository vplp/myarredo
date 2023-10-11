<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m180910_142202_update_catalog_factory_promotion_table
 */
class m180910_142202_update_catalog_factory_promotion_table extends Migration
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
            'amount_with_vat',
            "decimal(10,2) NOT NULL DEFAULT '0.00' AFTER amount"
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'amount_with_vat');
    }
}
