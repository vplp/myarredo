<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m220825_144840_add_column__phone__to_catalog_sale_item extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_sale_item}}';

    /**
    *
    */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    public function safeUp(): void
    {
        $this->addColumn($this->table, 'phone', $this->string(255)->null()->comment('Number phone'));
    }

    public function safeDown(): void
    {
        $this->dropColumn($this->table, 'phone');
    }
}
