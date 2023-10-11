<?php

use thread\modules\sys\Sys;
use yii\db\Migration;

/**
 * Handles the creation of table `system_logbook_auth`.
 */
class m190307_152037_create_system_logbook_auth_table extends Migration
{
    use \thread\app\base\db\mysql\MySqlExtraTypesTrait;
    use \thread\app\base\db\mysql\ThreadMySqlExtraTypesTrait;

    /**
     * @var string
     */
    public $tableLogbookAuth = '{{%system_logbook_auth}}';

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

        $this->createTable($this->tableLogbookAuth, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('User'),
            'type' => $this->enum(['notice', 'warning', 'error'], 'notice')->comment('Type'),
            'action' => $this->string(50)->notNull()->comment('Action'),
            'user_ip' => $this->string(25)->notNull()->comment('User IP'),
            'user_agent' => $this->string(255)->notNull()->comment('User Agent'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'is_read' => $this->enum([0, 1], 0)->comment('is_read'),
            'published' => $this->enum([0, 1], 0)->comment('Published'),
            'deleted' => $this->enum([0, 1], 0)->comment('Deleted'),
        ]);
        $this->createIndex('type', $this->tableLogbookAuth, 'type');
        $this->createIndex('is_read', $this->tableLogbookAuth, 'is_read');
        $this->createIndex('user_id', $this->tableLogbookAuth, 'user_id');
        $this->createIndex('published', $this->tableLogbookAuth, 'published');
        $this->createIndex('action', $this->tableLogbookAuth, 'action');
        $this->createIndex('deleted', $this->tableLogbookAuth, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableLogbookAuth);
        $this->dropIndex('published', $this->tableLogbookAuth);
        $this->dropIndex('type', $this->tableLogbookAuth);
        $this->dropIndex('is_read', $this->tableLogbookAuth);
        $this->dropIndex('action', $this->tableLogbookAuth);
        $this->dropIndex('user_id', $this->tableLogbookAuth);
        $this->dropTable($this->tableLogbookAuth);
    }
}