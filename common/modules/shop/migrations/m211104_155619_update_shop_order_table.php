<?php

use yii\db\Migration;
use common\modules\shop\Shop as ParentModule;

class m211104_155619_update_shop_order_table extends Migration
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

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'city_name', $this->string(255)->defaultValue(null)->after('city_id'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'city_name');
    }
}
