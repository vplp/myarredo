<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

/**
 * Class m171004_140840_update_user_profile_table
 */
class m171004_140840_update_user_profile_table extends Migration
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
        $this->addColumn($this->tableUserProfile, 'latitude', $this->float()->defaultValue(0)->comment('latitude'));
        $this->addColumn($this->tableUserProfile, 'longitude', $this->float()->defaultValue(0)->comment('longitude'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableUserProfile, 'latitude');
        $this->dropColumn($this->tableUserProfile, 'longitude');
    }
}
