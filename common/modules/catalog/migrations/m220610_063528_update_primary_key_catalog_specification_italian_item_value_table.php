<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m220610_063528_update_primary_key_catalog_specification_italian_item_value_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_specification_italian_item_value}}';

    public function safeUp(): void
    {
        $this->execute('
            ALTER TABLE fv_catalog_specification_italian_item_value 
            DROP PRIMARY KEY, ADD PRIMARY KEY(specification_id, item_id, val)
        ');
    }

    public function safeDown(): void
    {
        $this->execute('
            ALTER TABLE fv_catalog_specification_italian_item_value 
            DROP PRIMARY KEY, ADD PRIMARY KEY(specification_id, item_id)
        ');
    }
}
