<?php

use yii\db\Migration;
use common\modules\forms\FormsModule;

/**
 * Handles the creation of table `{{%forms_feedback_after_order}}`.
 */
class m230717_074206_create_forms_feedback_after_order_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%forms_feedback_after_order}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = FormsModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->table, [

            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'question_1' => $this->string(255)->notNull()->comment('Question_1'),
            'question_2' => $this->string(255)->notNull()->comment('Question_2'),
            'question_3' => $this->string(2048)->notNull()->comment('Question_3'),
            'question_4' => $this->string(2048)->notNull()->comment('Question_4'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Created time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Updated time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
        ]);

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
