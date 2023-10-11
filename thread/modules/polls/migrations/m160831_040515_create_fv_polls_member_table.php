<?php

use yii\db\Migration;
use thread\modules\polls\Polls;

/**
 * Class m160831_040515_create_fv_polls_member_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160831_040515_create_fv_polls_member_table extends Migration
{
    /**
     * @var string
     */
    public $tablePoll = '{{%polls_member}}';

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
            'poll_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Number of votes'),
            'vote_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Start time'),
            'member_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Finish time'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);

        $this->createIndex('poll_unique', $this->tablePoll, ['poll_id', 'vote_id', 'member_id'], true);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('poll_unique', $this->tablePoll);
        $this->dropTable($this->tablePoll);
    }
}
