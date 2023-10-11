<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191108_142456_update_user_profile_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%user_profile_lang}}';

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
        $this->addColumn($this->tableLang, 'address2', $this->string(255)->defaultValue(null)->after('address'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableLang, 'address2');
    }
}
