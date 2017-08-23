<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

/**
 * Class m170823_142042_update_user_profile_table
 */
class m170823_142042_update_user_profile_table extends Migration
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
        $this->addColumn($this->tableUserProfile, 'country_id', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('avatar'));
        $this->addColumn($this->tableUserProfile, 'city_id', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->after('country_id'));
        $this->addColumn($this->tableUserProfile, 'phone', $this->string(255)->defaultValue(null)->after('city_id'));
        $this->addColumn($this->tableUserProfile, 'address', $this->string(255)->defaultValue(null)->after('phone'));
        $this->addColumn($this->tableUserProfile, 'name_company', $this->string(255)->defaultValue(null)->after('address'));
        $this->addColumn($this->tableUserProfile, 'website', $this->string(255)->defaultValue(null)->after('name_company'));
        $this->addColumn($this->tableUserProfile, 'exp_with_italian', $this->string(255)->defaultValue(null)->after('website'));
        $this->addColumn($this->tableUserProfile, 'delivery_to_other_cities', "enum('0','1') NOT NULL DEFAULT '0' AFTER exp_with_italian");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableUserProfile, 'delivery_to_other_cities');
        $this->dropColumn($this->tableUserProfile, 'exp_with_italian');
        $this->dropColumn($this->tableUserProfile, 'website');
        $this->dropColumn($this->tableUserProfile, 'name_company');
        $this->dropColumn($this->tableUserProfile, 'address');
        $this->dropColumn($this->tableUserProfile, 'phone');
        $this->dropColumn($this->tableUserProfile, 'city_id');
        $this->dropColumn($this->tableUserProfile, 'country_id');
    }
}
