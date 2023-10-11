<?php

use yii\db\Migration;
use common\modules\forms\FormsModule as ParentModule;

class m200702_130859_update_forms_feedback_table extends Migration
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
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'city_id', $this->integer(11)->notNull()->defaultValue(0)->after('partner_id'));
        $this->createIndex('city_id', $this->table, 'city_id');

        $this->addColumn($this->table, 'country', $this->string(255)->defaultValue(null)->after('city_id'));
        $this->addColumn($this->table, 'subject', $this->string(255)->defaultValue(null)->after('country'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'subject');
        $this->dropColumn($this->table, 'country');

        $this->dropIndex('city_id', $this->table);
        $this->dropColumn($this->table, 'city_id');
    }
}
