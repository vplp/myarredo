<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m190611_091540_add_indexes_for_user_tables extends Migration
{
    // Group
    public $tableGroup = '{{%user_group}}';

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
        // Group
        $this->createIndex('role', $this->tableGroup, 'role');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Group
        $this->dropIndex('role', $this->tableGroup);
    }
}
