<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191030_082828_update_user_profile_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableUserProfile = '{{%user_profile}}';

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
        $this->dropColumn($this->tableUserProfile, 'name_company');
        $this->dropColumn($this->tableUserProfile, 'address');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->addColumn($this->tableUserProfile, 'address', $this->string(255)->defaultValue(null)->after('phone'));
        $this->addColumn($this->tableUserProfile, 'name_company', $this->string(255)->defaultValue(null)->after('address'));
    }
}
