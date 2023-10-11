<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191101_145938_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'answers_per_month', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->createIndex('answers_per_month', $this->table, 'answers_per_month');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('answers_per_month', $this->table);
        $this->dropColumn($this->table, 'answers_per_month');
    }
}
