<?php

use yii\db\Migration;
use common\modules\location\Location as ParentModule;

class m210223_170109_update_location_city_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%location_city}}';

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
        $this->addColumn($this->table, 'jivosite', $this->string(255)->notNull());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'jivosite');
    }
}
