<?php

use yii\db\Migration;
use thread\modules\configs\Configs as ConfigsModule;

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
        $this->db = ConfigsModule::getDb();
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
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
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
