<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m190612_121224_update_user_profile_table extends Migration
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
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'image_link',
            $this
                ->string(255)
                ->defaultValue(null)
                ->comment('Image link')
                ->after('avatar')
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_link');
    }
}
