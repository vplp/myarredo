<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m210413_120937_update_shop_order_table extends Migration
{

    /**
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
        $this->alterColumn($this->table, 'order_status', "enum('new','in_work','given_to_salon','contract_signed','failure','archive') NOT NULL DEFAULT 'new'");
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'order_status', "enum('new','in_work','given_to_salon','contract_signed','failure','archive') NOT NULL DEFAULT 'new'");
    }
}
