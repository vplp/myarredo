<?php

use yii\db\Migration;

/**
 * Class m170630_215226_create_table_feedback_group
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170630_215226_create_table_feedback_group extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%feedback_group}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'position' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('created_at'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('updated_at'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'"
        ]);

        $this->createIndex('position', $this->table, 'position');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('position', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropTable($this->table);
    }
}
