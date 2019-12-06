<?php

use yii\db\Migration;
//
use common\modules\user\User as UserModule;

class m191206_083846_update_user_profile_table extends Migration
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
            'image_salon',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_link')
        );

        $this->addColumn(
            $this->table,
            'image_salon2',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('image_salon')
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'image_salon2');
        $this->dropColumn($this->table, 'image_salon');
    }
}
