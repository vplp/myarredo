<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m180329_105331_update_user_profile_table extends Migration
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
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'factory_package', "enum('0','1','2') NOT NULL DEFAULT '0'");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'factory_package');
    }
}
