<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m210415_152823_update_shop_order_comment_table extends Migration
{
    /**
    * @var string
    */
    public $table = '{{%shop_order_comment}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'processed', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->createIndex('processed', $this->table, 'processed');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropIndex('processed', $this->table);
        $this->dropColumn($this->table, 'processed');
    }
}
