<?php
use yii\db\Migration;
use thread\modules\forms\Forms;

/**
 * Class m160725_101123_create_fv_feedbacks
 *
 * @package thread\modules\forms
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */

class m160725_101123_create_fv_feedbacks extends Migration
{
    /**
     * @var string
     */
    public $tableFeedbackForm = '{{%feedbacks}}';
    
    /**
     * @var string
     */
    public $tableTopic = '{{%feedback_topics}}';

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
        $this->createTable($this->tableFeedbackForm, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'topic_id' => $this->integer(11)->unsigned()->notNull()->comment('Related group'),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'phone' => $this->integer(10)->defaultValue(null)->defaultValue(0)->comment('Phone'),
            'question' => $this->string(255)->notNull()->comment('Question'),
            'email' => $this->string(255)->notNull()->comment('Email'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
        ]);
        $this->createIndex('published', $this->tableFeedbackForm, 'published');
        $this->createIndex('deleted', $this->tableFeedbackForm, 'deleted');
        $this->createIndex('topic_id', $this->tableFeedbackForm, 'topic_id');
        $this->addForeignKey(
            'fk-feedback-topic_id-feedback_topics_topic_id',
            $this->tableFeedbackForm,
            'topic_id',
            $this->tableTopic,
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
        $this->dropForeignKey('fk-feedback-topic_id-feedback_topics_topic_id', $this->tableFeedbackForm);
        $this->dropIndex('topic_id', $this->tableFeedbackForm);
        $this->dropIndex('deleted', $this->tableFeedbackForm);
        $this->dropIndex('published', $this->tableFeedbackForm);
        $this->dropTable($this->tableFeedbackForm);
    }
}
