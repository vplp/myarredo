<?php

use yii\db\Migration;
use common\modules\user\User as ParentModule;

class m220120_143455_update_user_profile_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%user_profile}}';

    /**
     *
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'selected_languages',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('preferred_language')
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'selected_languages');
    }
}
