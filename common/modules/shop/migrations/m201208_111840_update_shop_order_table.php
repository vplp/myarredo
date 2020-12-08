<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m201208_111840_update_shop_order_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%shop_order}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn($this->table, 'order_mobile', "enum('0','1') NOT NULL DEFAULT '0' AFTER order_first_url_visit");
        $this->createIndex('order_mobile', $this->table, 'order_mobile');
    }

    public function safeDown()
    {
        $this->dropIndex('order_mobile', $this->table);
        $this->dropColumn($this->table, 'order_mobile');
    }
}
