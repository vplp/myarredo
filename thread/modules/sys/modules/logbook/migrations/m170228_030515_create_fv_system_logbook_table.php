<?php

use yii\db\Migration;
use thread\modules\sys\Sys;

/**
 * Class m170228_030515_create_fv_system_logbook_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170228_030515_create_fv_system_logbook_table extends Migration
{
    /**
     * @var string
     */
    public $tableCronTab = '{{%system_logbook}}';

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

        $this->createTable($this->tableCronTab, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('User'),
            'type' => "enum('notice', 'warning', 'error') NOT NULL DEFAULT 'notice' COMMENT 'Type'",
            'message' => $this->string(512)->notNull()->comment('Message'),
            'category' => $this->string(512)->notNull()->comment('Category'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'is_read' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is read'",
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);
//
        $this->createIndex('type', $this->tableCronTab, 'type');
        $this->createIndex('is_read', $this->tableCronTab, 'is_read');
        $this->createIndex('user_id', $this->tableCronTab, 'user_id');
        $this->createIndex('published', $this->tableCronTab, 'published');
        $this->createIndex('deleted', $this->tableCronTab, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableCronTab);
        $this->dropIndex('published', $this->tableCronTab);
        $this->dropIndex('type', $this->tableCronTab);
        $this->dropIndex('is_read', $this->tableCronTab);
        $this->dropIndex('user_id', $this->tableCronTab);
        $this->dropTable($this->tableCronTab);
    }
}
