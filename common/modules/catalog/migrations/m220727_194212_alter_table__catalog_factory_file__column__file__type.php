<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m220727_194212_alter_table__catalog_factory_file__column__file__type extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%_catalog_factory_file}}';

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
        $this->execute('ALTER TABLE fv_catalog_factory_file MODIFY file_type enum("1","2","3")
        COMMENT "Тип файла 1 - каталог, 2 - прайс, 3 - вариант отделки"');
    }

    public function safeDown()
    {
        $this->execute('ALTER TABLE fv_catalog_factory_file MODIFY file_type enum("1","2")
        COMMENT "Тип файла 1 - каталог, 2 - прайс"');
    }
}
