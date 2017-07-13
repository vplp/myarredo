<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002445_create_fv_user
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_002445_create_fv_user extends Migration
{
    /**
     * User table name
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * User group table name
     * @var string
     */
    public $tableUserGroup = '{{%user_group}}';

    /**
     * Get core DB connection
     */
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
        /** Create table */
        $this->createTable($this->tableUser, [
            'id' => $this->primaryKey(11)->unsigned()->notNull()->comment('ID'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Group'),
            'username' => $this->string(255)->unique()->notNull()->comment('Username'),
            'email' => $this->string(255)->unique()->notNull()->comment('Email'),
            'auth_key' => $this->string(32)->notNull()->comment('Auth key'),
            'password_hash' => $this->string(255)->notNull()->comment('Password hash'),
            'password_reset_token' => $this->string(255)->defaultValue(null)->comment('Password reset token'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);

        /** Create indexes */
        $this->createIndex('published', $this->tableUser, 'published');
        $this->createIndex('deleted', $this->tableUser, 'deleted');
        $this->createIndex('group', $this->tableUser, 'group_id');

        /** Add FKs */
        $this->addForeignKey(
            'fk-user-group_id-user_group-id',
            $this->tableUser,
            'group_id',
            $this->tableUserGroup,
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
        /** Delete FK */
        $this->dropForeignKey('fk-user-group_id-user_group-id', $this->tableUser);
        /** Drop indexes */
        $this->dropIndex('group', $this->tableUser);
        $this->dropIndex('deleted', $this->tableUser);
        $this->dropIndex('published', $this->tableUser);

        /** Drop table */
        $this->dropTable($this->tableUser);
    }
}
