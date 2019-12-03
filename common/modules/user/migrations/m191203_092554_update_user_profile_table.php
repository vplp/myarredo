<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191203_092554_update_user_profile_table extends Migration
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
        $this->addColumn($this->table, 'latitude2', $this->float()->defaultValue(0)->after('latitude'));
        $this->addColumn($this->table, 'longitude2', $this->float()->defaultValue(0)->after('longitude'));
        $this->addColumn($this->table, 'working_hours_start', $this->string(255)->defaultValue(null)->after('longitude'));
        $this->addColumn($this->table, 'working_hours_end', $this->string(255)->defaultValue(null)->after('working_hours_start'));
        $this->addColumn($this->table, 'working_hours_start2', $this->string(255)->defaultValue(null)->after('longitude2'));
        $this->addColumn($this->table, 'working_hours_end2', $this->string(255)->defaultValue(null)->after('working_hours_start2'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'working_hours_end2');
        $this->dropColumn($this->table, 'working_hours_start2');
        $this->dropColumn($this->table, 'working_hours_end');
        $this->dropColumn($this->table, 'working_hours_start');
        $this->dropColumn($this->table, 'longitude2');
        $this->dropColumn($this->table, 'latitude2');
    }
}
