<?php

use yii\db\Migration;
use thread\modules\sys\modules\configs\Configs as ConfigsModule;

/**
 * Class m160808_130448_add_column_alias_to_configs_params
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160808_130448_add_column_alias_to_configs_params extends Migration
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
        $this->addColumn($this->tableConfigsParams, 'alias', $this->string(255)->notNull()->unique()->comment('Alias'));
    }

    /**
     *
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableConfigsParams, 'alias');
    }
}
