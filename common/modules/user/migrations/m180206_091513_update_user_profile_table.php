<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m180206_091513_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'email_company', $this->string(255)->defaultValue(null)->after('name_company'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'email_company');
    }
}
