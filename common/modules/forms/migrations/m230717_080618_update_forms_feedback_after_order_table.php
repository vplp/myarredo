<?php

use yii\db\Migration;
use common\modules\forms\FormsModule;

class m230717_080618_update_forms_feedback_after_order_table extends Migration
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
        $this->addColumn($this->table, 'order_id', $this->integer(11)->notNull()->defaultValue(0)->after('id'));
        $this->createIndex('order_id', $this->table, 'order_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('order_id', $this->table);
        $this->dropColumn($this->table, 'order_id');
    }
}
