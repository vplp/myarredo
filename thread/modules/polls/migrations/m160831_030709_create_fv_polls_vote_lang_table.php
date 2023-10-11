<?php

use yii\db\Migration;
use thread\modules\polls\Polls;

/**
 * Class m160831_030709_create_fv_polls_vote_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160831_030709_create_fv_polls_vote_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tableVote = '{{%polls_vote}}';

    /**
     * @var string
     */
    public $tableVoteLang = '{{%polls_vote_lang}}';

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
        $this->createTable($this->tableVoteLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);
        $this->createIndex('rid', $this->tableVoteLang, ['rid', 'lang'], true);
        $this->addForeignKey(
            'fk-polls_vote_lang-rid-polls_vote-id',
            $this->tableVoteLang,
            'rid',
            $this->tableVote,
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
        $this->dropForeignKey('fk-polls_vote_lang-rid-polls_vote-id', $this->tableVoteLang);
        $this->dropIndex('rid', $this->tableVoteLang);
        $this->dropTable($this->tableVoteLang);
    }
}
