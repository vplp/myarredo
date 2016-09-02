<?php

use yii\db\Migration;
use thread\modules\sys\Sys;

/**
 * Class m160902_030515_create_fv_system_growl_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160902_030515_create_fv_system_growl_table extends Migration
{
    /**
     * @var string
     */
    public $tableSysGrowl = '{{%system_growl}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Sys::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableSysGrowl, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->notNull()->comment('User'),
            'message' => $this->string(255)->notNull()->comment('Message'),
            'model' => $this->string(50)->notNull()->comment('Model'),
            'url' => $this->string(512)->notNull()->comment('Url'),
            'type' => "enum('notice','warning', 'error') NOT NULL DEFAULT 'notice' COMMENT 'Type'",
            'priority' => $this->integer()->notNull()->comment('Priority'),
            'is_read' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is read'",
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->tableSysGrowl, 'published');
        $this->createIndex('deleted', $this->tableSysGrowl, 'deleted');
        $this->createIndex('model', $this->tableSysGrowl, 'model');
        $this->createIndex('user_id', $this->tableSysGrowl, 'user_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableSysGrowl);
        $this->dropIndex('published', $this->tableSysGrowl);
        $this->dropIndex('model', $this->tableSysGrowl);
        $this->dropIndex('user_id', $this->tableSysGrowl);
        $this->dropTable($this->tableSysGrowl);
    }
}
