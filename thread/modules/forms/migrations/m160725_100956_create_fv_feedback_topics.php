<?php

use yii\db\Migration;
use thread\modules\forms\Forms;

/**
 * Class m160725_100956_create_fv_feedback_topics
 *
 * @package thread\modules\forms
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class m160725_100956_create_fv_feedback_topics extends Migration
{
    /**
     * @var string
     */
    public $tableFeedbackTopics = '{{%feedback_topics}}';

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
        $this->createTable($this->tableFeedbackTopics, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'sort' => $this->integer(10)->notNull()->defaultValue(0)->comment('Sort'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
        ]);

        $this->createIndex('published', $this->tableFeedbackTopics, 'published');
        $this->createIndex('deleted', $this->tableFeedbackTopics, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tableFeedbackTopics);
        $this->dropIndex('published', $this->tableFeedbackTopics);
        $this->dropTable($this->tableFeedbackTopics);
    }
}
