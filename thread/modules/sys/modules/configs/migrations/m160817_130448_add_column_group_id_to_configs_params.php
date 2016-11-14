<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160817_130448_add_column_group_id_to_configs_params
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160817_130448_add_column_group_id_to_configs_params extends Migration
{

    /**
     * @var string
     */
    public $tableConfigsParams = '{{%configs_params}}';

    public function init()
    {
        $this->db = ConfigsModule::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp()
    {
        $this->addColumn($this->tableConfigsParams, 'group_id', $this->integer(11)->unsigned()->defaultValue(0)->comment('Group'));
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableConfigsParams, 'group_id');
    }
}
