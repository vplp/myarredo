<?php

use yii\db\Migration;
//
use common\modules\sys\modules\configs\Configs as ConfigsModule;

class m180328_092543_update_sys_configs_params_lang_table extends Migration
{
    /**
     * Catalog product table name
     * @var string
     */
    public $tableLang = '{{%system_configs_params_lang}}';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->db = ConfigsModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableLang, 'content', $this->text()->defaultValue(null)->comment('Content')->after('title'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableLang, 'content');
    }
}
