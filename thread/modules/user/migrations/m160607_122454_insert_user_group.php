<?php

use yii\db\Migration;

/**
 * Class m160607_122454_insert_user_group
 *
 * @package thread\modules\user
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160607_122454_insert_user_group extends Migration
{
    /**
     * User group table name
     * @var string
     */
    public $tableUserGroup = '{{%user_group}}';

    /**
     * Language table for user group
     * @var string
     */
    public $tableUserGroupLang = '{{%user_group_lang}}';

    /**
     * Language table for user group
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        /** Insert into User Group table */
        $this->batchInsert(
            $this->tableUserGroup,
            [
                'id',
                'alias',
                'role',
                'published',
                'deleted',
                'created_at',
                'updated_at',
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'admin',
                    'role' => 'admin',
                    'published' => '1',
                    'deleted' => '0',
                    'created_at' => time(),
                    'updated_at' => time()
                ],
                [
                    'id' => 2,
                    'alias' => 'user',
                    'role' => 'user',
                    'published' => '1',
                    'deleted' => '0',
                    'created_at' => time(),
                    'updated_at' => time()
                ],
            ]
        );

        /** Insert into Language User Group table */
        $this->batchInsert(
            $this->tableUserGroupLang,
            [
                'rid',
                'lang',
                'title'
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'uk-UA',
                    'title' => 'Адміністратор'
                ],
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'Administrator'
                ],
                [
                    'rid' => 1,
                    'lang' => 'ru-RU',
                    'title' => 'Администратор'
                ],
                [
                    'rid' => 2,
                    'lang' => 'uk-UA',
                    'title' => 'Користувач'
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'User'
                ],
                [
                    'rid' => 2,
                    'lang' => 'ru-RU',
                    'title' => 'Польователь'
                ],
            ]
        );
            
    }

    public function safeDown()
    {
        /** Empty language table */
        $this->truncateTable($this->tableUserGroupLang);

        /** Drop FKs */
        $this->dropForeignKey('fk-user_group_lang-rid-user_group-id', $this->tableUserGroupLang);
        $this->dropForeignKey('fk-user-group_id-user_group-id', $this->tableUser);

        /** Empty main table */
        $this->truncateTable($this->tableUserGroup);

        /** Re-create FKs */
        $this->addForeignKey(
            'fk-user_group_lang-rid-user_group-id',
            $this->tableUserGroupLang,
            'rid',
            $this->tableUserGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );

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
}
