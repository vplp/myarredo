<?php

use yii\db\Migration;
use thread\modules\configs\Configs as ConfigsModule;

/**
 * Class m160808_100956_create_fv_configs_params
 *
 * @package thread\modules\configs\migrations
 * @copyright (c) 2016, VipDesign
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
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
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
