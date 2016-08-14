<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002500_create_fv_user_profile
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_002500_create_fv_user_profile extends Migration
{

    /**
     * User table name
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * @var string
     */
    public $tableUserProfile = '{{%user_profile}}';

    public function init()
    {
        $this->db = User::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableUserProfile, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->unique()->notNull()->comment('User'),
            'first_name' => $this->string(255)->defaultValue(null)->comment('First name'),
            'last_name' => $this->string(255)->defaultValue(null)->comment('Last name'),
            'avatar' => $this->string(255)->defaultValue(null)->comment('avatar'),
            'preferred_language' => $this->char(5)->notNull()->defaultValue('en-EN')->comment('Preferred language'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);

        $this->createIndex('first_name', $this->tableUserProfile, 'first_name');
        $this->createIndex('last_name', $this->tableUserProfile, 'last_name');

        $this->addForeignKey(
            'fk-user_profile-user_id-user-id',
            $this->tableUserProfile,
            'user_id',
            $this->tableUser,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_profile-user_id-user-id', $this->tableUserProfile);
        $this->dropIndex('last_name', $this->tableUserProfile);
        $this->dropIndex('first_name', $this->tableUserProfile);
        $this->dropTable($this->tableUserProfile);
    }
}
