<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191015_101852_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark'");
        $this->createIndex('mark', $this->table, 'mark');

        $this->addColumn($this->table, 'language_editing', $this->string(5)->defaultValue(null)->after('mark'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'language_editing');

        $this->dropIndex('mark', $this->table);
        $this->dropColumn($this->table, 'mark');
    }
}
