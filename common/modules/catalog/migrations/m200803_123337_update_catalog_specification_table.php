<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m200803_123337_update_catalog_specification_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_specification}}';

    /**
     * @inheritdoc
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
        $this->renameColumn($this->table, 'alias2', 'alias_en');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'alias_en', 'alias2');
    }
}
