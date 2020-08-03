<?php

use yii\db\Migration;
use thread\app\base\module\abstracts\Module as ParentModule;

class m200803_123303_update_catalog_types_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_type}}';

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
