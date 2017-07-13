<?php

use yii\db\Migration;
use thread\modules\polls\Polls;

/**
 * Class m160831_030515_create_fv_polls_poll_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160831_030515_create_fv_polls_poll_table extends Migration
{
    /**
     * @var string
     */
    public $tablePoll = '{{%polls_poll}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Polls::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePoll, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'number_of_votes' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Number of votes'),
            'start_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Start time'),
            'finish_time' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Finish time'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->tablePoll, 'published');
        $this->createIndex('deleted', $this->tablePoll, 'deleted');
        $this->createIndex('start_time', $this->tablePoll, 'start_time');
        $this->createIndex('finish_time', $this->tablePoll, 'finish_time');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tablePoll);
        $this->dropIndex('published', $this->tablePoll);
        $this->dropIndex('start_time', $this->tablePoll);
        $this->dropIndex('finish_time', $this->tablePoll);
        $this->dropTable($this->tablePoll);
    }
}
