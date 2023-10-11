<?php

use yii\db\Migration;
use common\modules\user\User as ParentModule;

class m201222_160052_update_user_profile_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%user_profile}}';

    /**
     *
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
        $this->addColumn($this->table, 'possibility_to_answer_com_de', "enum('0','1') NOT NULL DEFAULT '0'");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'possibility_to_answer_com_de');
    }
}
