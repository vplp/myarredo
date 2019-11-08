<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191108_142435_update_user_profile_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%user_profile}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = UserModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'phone2', $this->string(255)->defaultValue(null)->after('phone'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'phone2');
    }
}
