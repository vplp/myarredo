<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160817_030515_create_fv_configs_group_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160817_030515_create_fv_configs_group_table extends Migration
{
    /**
     * @var string
     */
    public $tableConfigsGroup = '{{%configs_group}}';

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
        $this->createTable($this->tableConfigsGroup, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->tableConfigsGroup, 'published');
        $this->createIndex('deleted', $this->tableConfigsGroup, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableConfigsGroup);
        $this->dropIndex('published', $this->tableConfigsGroup);
        $this->dropTable($this->tableConfigsGroup);
    }
}
