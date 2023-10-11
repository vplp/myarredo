<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m171211_145123_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'factory_id', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('user_id'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'factory_id');
    }
}
