<?php

use yii\db\Migration;

/**
 * Class m170630_215251_create_table_feedback_question
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170630_215251_create_table_feedback_question extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%feedback_question}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'group_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('group_id'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('created_at'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('updated_at'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'",
            'subject' => $this->string(255)->notNull()->comment('subject'),
            'user_name' => $this->string(255)->notNull()->comment('user_name'),
            'question' => $this->string(255)->notNull()->comment('question'),
            'email' => $this->string(255)->notNull()->comment('email')
        ]);

        $this->createIndex('group_id', $this->table, 'group_id');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('group_id', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropTable($this->table);
    }
}
