<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191018_121408_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'show_contacts_on_sale', "enum('0','1') NOT NULL DEFAULT '1' AFTER show_contacts");
        $this->createIndex('show_contacts_on_sale', $this->table, 'show_contacts_on_sale');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('show_contacts_on_sale', $this->table);
        $this->dropColumn($this->table, 'show_contacts_on_sale');
    }
}
