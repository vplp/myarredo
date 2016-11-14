<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m160810_130204_create_table_languages
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160810_130204_create_table_languages extends Migration
{
    /**
     * @var string
     */
    public $tableLanguages = '{{%languages}}';

    /**
     *
     */
    public function init()
    {
        $this->db = SysModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableLanguages, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(50)->notNull()->comment('Value'),
            'local' => $this->string(50)->notNull()->comment('local'),
            'label' => $this->string(50)->notNull()->comment('label'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->tableLanguages, 'published');
        $this->createIndex('deleted', $this->tableLanguages, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableConfigsParams);
        $this->dropIndex('published', $this->tableConfigsParams);
    }
}
