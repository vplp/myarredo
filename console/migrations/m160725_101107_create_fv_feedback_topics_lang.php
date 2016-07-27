<?php

use yii\db\Migration;
use thread\modules\forms\Forms;

/**
 * Class m160725_101107_create_fv_feedback_topics_lang
 *
 * @package thread\modules\forms
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */

class m160725_101107_create_fv_feedback_topics_lang extends Migration
{
    /**
     * @var string
     */
    public $tableFeedbackTopics = '{{%feedback_topics}}';

    /**
     * @var string
     */
    public $tableFeedbackTopicsLang = '{{%feedback_topics_lang}}';

    public function init()
    {
        $this->db = Forms::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableFeedbackTopicsLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableFeedbackTopicsLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-topic_lang-rid-topic-id',
            $this->tableFeedbackTopicsLang,
            'rid',
            $this->tableFeedbackTopics,
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
        $this->dropForeignKey('fk-topic_lang-rid-topic-id', $this->tableFeedbackTopicsLang);
        $this->dropIndex('rid', $this->tableFeedbackTopicsLang);
        $this->dropTable($this->tableFeedbackTopicsLang);
    }
}
