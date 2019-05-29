<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m190529_103200_update_user_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user}}';

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
        $this->addColumn($this->table, 'password', $this->string(255)->defaultValue(null)->after('auth_key'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'password');
    }
}
