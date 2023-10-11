<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160808_100956_create_fv_configs_params
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160808_100956_create_fv_configs_params extends Migration
{
    /**
     * @var string
     */
    public $tableConfigsParams = '{{%configs_params}}';

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
        $this->createTable($this->tableConfigsParams, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'value' => $this->string(1024)->notNull()->comment('Value'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
        ]);

        $this->createIndex('published', $this->tableConfigsParams, 'published');
        $this->createIndex('deleted', $this->tableConfigsParams, 'deleted');
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
