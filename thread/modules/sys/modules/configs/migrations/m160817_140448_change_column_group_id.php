<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160817_140448_change_column_group_id
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160817_140448_change_column_group_id extends Migration
{

    /**
     * @var string
     */
    public $tableConfigsParams = '{{%configs_params}}';

    /**
     * @var string
     */
    public $tableConfigsGroup = '{{%configs_group}}';

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
        $this->alterColumn($this->tableConfigsParams, 'group_id', $this->integer(11)->unsigned());

        $this->createIndex('group_id', $this->tableConfigsParams, 'group_id');

        $this->addForeignKey(
            'fv_configs_params_ibfk_1',
            $this->tableConfigsParams,
            'group_id',
            $this->tableConfigsGroup,
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropForeignKey('fv_configs_params_ibfk_1', $this->tableConfigsParams);

        $this->dropIndex('group_id', $this->tableConfigsParams);

        $this->alterColumn($this->tableConfigsParams, 'group_id', $this->integer(11));
    }
}
