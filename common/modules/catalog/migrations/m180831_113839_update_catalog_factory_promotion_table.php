<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180831_113839_update_catalog_factory_promotion_table extends Migration
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
            'payment_object',
            $this->text()->defaultValue(null)->after('payment_status')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'payment_object');
    }
}
