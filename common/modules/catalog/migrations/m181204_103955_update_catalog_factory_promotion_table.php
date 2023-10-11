<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m181204_103955_update_catalog_factory_promotion_table
 */
class m181204_103955_update_catalog_factory_promotion_table extends Migration
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
        $this->dropColumn($this->table, 'payment_status');
        $this->addColumn(
            $this->table,
            'payment_status',
            "enum('pending','accepted','success','fail') NOT NULL DEFAULT 'pending' after status"
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'payment_status');
        $this->addColumn(
            $this->table,
            'payment_status',
            "enum('new','paid') NOT NULL DEFAULT 'new' after status"
        );
    }
}
