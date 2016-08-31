<?php

use yii\db\Migration;
use thread\modules\polls\Polls;

/**
 * Class m160831_030655_create_fv_polls_vote_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160831_030655_create_fv_polls_vote_table extends Migration
{
    /**
     * @var string
     */
    public $tablePollVote = '{{%polls_vote}}';

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
        $this->createTable($this->tablePollVote, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('Related poll'),
            'number_of_votes' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Number of votes'),
            'position' => $this->integer(10)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);
        $this->createIndex('published', $this->tablePollVote, 'published');
        $this->createIndex('deleted', $this->tablePollVote, 'deleted');
        $this->createIndex('group_id', $this->tablePollVote, 'group_id');
        $this->addForeignKey(
            'fk-polls_vote-group_id-polls_poll-id',
            $this->tablePollVote,
            'group_id',
            $this->tablePoll,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-polls_vote-group_id-polls_poll-id', $this->tablePollVote);
        $this->dropIndex('group_id', $this->tablePollVote);
        $this->dropIndex('deleted', $this->tablePollVote);
        $this->dropIndex('published', $this->tablePollVote);
        $this->dropTable($this->tablePollVote);
    }
}
