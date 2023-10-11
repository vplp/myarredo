<?php

use yii\db\Migration;
//
use common\modules\forms\FormsModule;

class m191119_155509_update_forms_feedback_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%forms_feedback}}';

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
        $this->addColumn($this->table, 'partner_id', $this->integer(11)->notNull()->defaultValue(0)->after('id'));
        $this->createIndex('partner_id', $this->table, 'partner_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('partner_id', $this->table);
        $this->dropColumn($this->table, 'partner_id');
    }
}
