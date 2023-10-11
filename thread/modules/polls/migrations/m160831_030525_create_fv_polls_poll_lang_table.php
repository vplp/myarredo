<?php

use yii\db\Migration;
use thread\modules\polls\Polls;

/**
 * Class m160831_030525_create_fv_polls_poll_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160831_030525_create_fv_polls_poll_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tablePoll = '{{%polls_poll}}';

    /**
     * @var string
     */
    public $tablePollLang = '{{%polls_poll_lang}}';

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
        $this->createTable($this->tablePollLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tablePollLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-polls_poll_lang-rid-polls_poll-id',
            $this->tablePollLang,
            'rid',
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
        $this->dropForeignKey('fk-polls_poll_lang-rid-polls_poll-id', $this->tablePollLang);
        $this->dropIndex('rid', $this->tablePollLang);
        $this->dropTable($this->tablePollLang);
    }
}
