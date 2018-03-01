<?php

use yii\db\Migration;
//
use common\modules\sys\modules\configs\Configs as ConfigsModule;

class m180301_114936_update_sys_configs_params_table extends Migration
{
    /**
     * Catalog product table name
     * @var string
     */
    public $table = '{{%system_configs_params}}';

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
        $this->alterColumn($this->table, 'value', $this->text()->notNull()->comment('Value'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn($this->table, 'value', $this->string(1024)->notNull()->comment('Value'));
    }
}
