<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m220614_201030_add_column__to_translate__to_catalog_factory_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn($this->table, 'to_translate', "enum('0','1') NOT NULL DEFAULT '0'");
    }

    public function safeDown(): void
    {
        $this->dropColumn($this->table, 'to_translate');
    }
}
