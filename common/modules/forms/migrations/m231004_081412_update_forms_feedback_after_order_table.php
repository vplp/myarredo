<?php

use yii\db\Migration;
use common\modules\forms\FormsModule;

class m231004_081412_update_forms_feedback_after_order_table extends Migration
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
        $this->addColumn($this->table, 'vote', $this->integer(1)->notNull()->defaultValue(0)->after('question_4'));
        $this->createIndex('vote', $this->table, 'vote');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('vote', $this->table);
        $this->dropColumn($this->table, 'vote');
    }
}
