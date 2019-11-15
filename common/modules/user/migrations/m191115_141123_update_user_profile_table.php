<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191115_141123_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'partner_in_city_paid', "enum('0','1') NOT NULL DEFAULT '0' AFTER partner_in_city");
        $this->createIndex('partner_in_city_paid', $this->table, 'partner_in_city_paid');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('partner_in_city_paid', $this->table);
        $this->dropColumn($this->table, 'partner_in_city_paid');
    }
}
