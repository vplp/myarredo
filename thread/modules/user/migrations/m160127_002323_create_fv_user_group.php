<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002323_create_fv_user_group
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_002323_create_fv_user_group extends Migration
{
    /**
     * User group table name
     * @var string
     */
    public $tableUserGroup = '{{%user_group}}';

    /**
     * Get core DB
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
        $this->createTable($this->tableUserGroup, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->notNull()->unique()->comment('Alias'),
            'role' => $this->string(50)->notNull()->defaultValue('guest')->comment('Role'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
        ]);
        
        /** Add indexes */
        $this->createIndex('published', $this->tableUserGroup, 'published');
        $this->createIndex('deleted', $this->tableUserGroup, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        /** Drop indexes */
        $this->dropIndex('published', $this->tableUserGroup);
        $this->dropIndex('deleted', $this->tableUserGroup);

        /** Drop table */
        $this->dropTable($this->tableUserGroup);
    }
}
