<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m160810_145426_insert_table_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160810_145426_insert_table_lang extends Migration
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
        $this->addColumn($this->tableLanguages, 'default', $this->boolean()->notNull()->defaultValue(0)->comment('default'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn($this->tableLanguages, 'default');
    }

}
