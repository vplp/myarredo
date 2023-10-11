<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m180926_075608_update_user_profile_table extends Migration
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
        $this->createIndex('factory_id', $this->table, 'factory_id');
        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('city_id', $this->table, 'city_id');

        $this->createIndex('partner_in_city', $this->table, 'partner_in_city');
        $this->createIndex('possibility_to_answer', $this->table, 'possibility_to_answer');
        $this->createIndex('pdf_access', $this->table, 'pdf_access');
        $this->createIndex('show_contacts', $this->table, 'show_contacts');
        $this->createIndex('factory_package', $this->table, 'factory_package');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('factory_package', $this->table);
        $this->dropIndex('show_contacts', $this->table);
        $this->dropIndex('pdf_access', $this->table);
        $this->dropIndex('possibility_to_answer', $this->table);
        $this->dropIndex('partner_in_city', $this->table);

        $this->dropIndex('city_id', $this->table);
        $this->dropIndex('country_id', $this->table);
        $this->dropIndex('factory_id', $this->table);
    }
}
