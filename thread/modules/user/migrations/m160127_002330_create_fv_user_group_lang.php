<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002330_create_fv_user_group_lang
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c), Thread
 */
class m160127_002330_create_fv_user_group_lang extends Migration
{
    /**
     * User Group table name
     * @var string
     */
    public $tableUserGroup = '{{%user_group}}';

    /**
     * Language User Group table name
     * @var string
     */
    public $tableUserGroupLang = '{{%user_group_lang}}';

    /**
     * Core DB connection
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
        $this->createTable($this->tableUserGroupLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('rid'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title')
        ]);

        /** Add index */
        $this->createIndex('rid', $this->tableUserGroupLang, ['rid', 'lang'], true);

        /** Create FK */
        $this->addForeignKey(
            'fk-user_group_lang-rid-user_group-id',
            $this->tableUserGroupLang,
            'rid',
            $this->tableUserGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * cancel migration
     */
    public function safeDown()
    {
        /** Drop FK */
        $this->dropForeignKey('fk-user_group_lang-rid-user_group-id', $this->tableUserGroupLang);

        /** Drop index */
        $this->dropIndex('rid', $this->tableUserGroupLang);

        /** Drop table */
        $this->dropTable($this->tableUserGroupLang);
    }
}
