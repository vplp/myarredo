<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

class m160810_134446_add_column_flag extends Migration
{

    /**
     * @var string
     */
    public $tableLanguages = '{{%languages}}';

    /**
     *
     */
    public function init()
    {
        $this->db = SysModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn($this->tableLanguages, 'img_flag', $this->string(225)->defaultValue(null)->comment('email'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn($this->tableLanguages, 'img_flag');
    }
}
