<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m171206_124133_update_user_profile_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table= '{{%user_profile}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = UserModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'possibility_to_answer', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->addColumn($this->table, 'pdf_access', "enum('0','1') NOT NULL DEFAULT '0'");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'possibility_to_answer');
        $this->dropColumn($this->table, 'pdf_access');
    }
}
