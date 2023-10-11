<?php

use yii\db\Migration;

/**
 * Class m160705_104846_insert_default_users
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_104846_insert_default_users extends Migration
{
    /**
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * @var string
     */
    public $tableUserProfile = '{{%user_profile}}';


    public function safeUp()
    {
        /** Insert user */
        $this->batchInsert(
            $this->tableUser,
            [
                'id',
                'group_id',
                'username',
                'email',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'published',
                'deleted',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'id' => 1,
                    'group_id' => 1,
                    'username' => 'admin',
                    'email' => 'admin@admin.ua',
                    'auth_key' => '2YxdkqjeQNbqNt607WTJB1QPcUtgsKGs',
                    'password_hash' => '$2y$13$XCcJ9zM6YbClmQYmQd9l2.kM4cadZA5GQTajDkHsgml.IbogBKxdK',
                    'password_reset_token' => null,
                    'published' => '1',
                    'deleted' => '0',
                    'created_at' => time(),
                    'updated_at' => time(),
                ],
                [
                    'id' => 2,
                    'group_id' => 2,
                    'username' => 'user',
                    'email' => 'user@user.ua',
                    'auth_key' => 'g9RWKXYntJ8_P92pY6C6I_zTqv8PuxlC',
                    'password_hash' => '$2y$13$Knb3LBzYwfP6KkBnzc8pi.BoPgGoqLcVYMXReq.rvFQd5KAIdenJm',
                    'password_reset_token' => null,
                    'published' => '1',
                    'deleted' => '0',
                    'created_at' => time(),
                    'updated_at' => time(),
                ]
            ]
        );

        /** Insert profiles */
        $this->batchInsert(
            $this->tableUserProfile,
            [
                'id',
                'user_id',
                'first_name',
                'last_name',
                'avatar',
                'preferred_language',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'first_name' => 'Админ',
                    'last_name' => 'Багофиксенко',
                    'avatar' => null,
                    'preferred_language' => 'en-EN',
                    'created_at' => time(),
                    'updated_at' => time(),
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'first_name' => 'Юзер',
                    'last_name' => 'Криворученко',
                    'avatar' => null,
                    'preferred_language' => 'en-EN',
                    'created_at' => time(),
                    'updated_at' => time(),
                ]
            ]
        );
    }

    public function safeDown()
    {
        $this->truncateTable($this->tableUserProfile);
        $this->dropForeignKey('fk-user_profile-user_id-user-id', $this->tableUserProfile);
        $this->truncateTable($this->tableUser);
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
}
