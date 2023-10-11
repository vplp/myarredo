<?php

use yii\db\Migration;
//
use thread\modules\sys\Sys as SysModule;

class m190611_092150_add_indexes_for_languages_tables extends Migration
{
    // Languages
    public $tableLanguages = '{{%system_languages}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = SysModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Languages
        $this->createIndex('alias', $this->tableLanguages, 'alias');
        $this->createIndex('local', $this->tableLanguages, 'local');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Languages
        $this->dropIndex('alias', $this->tableLanguages);
        $this->dropIndex('local', $this->tableLanguages);
    }
}
