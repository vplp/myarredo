<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m161114_155426_rename_tables
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161114_155426_rename_tables extends Migration
{

    /**
     * @var string
     */
    public $tableConfigsParamsNew = '{{%system_configs_params}}';

    /**
     * @var string
     */
    public $tableConfigsParams = '{{%configs_params}}';

    /**
     * @var string
     */
    public $tableConfigsParamsLangNew = '{{%system_configs_params_lang}}';

    /**
     * @var string
     */
    public $tableConfigsParamsLang = '{{%configs_params_lang}}';


    /**
     * @var string
     */
    public $tableConfigsGroupNew = '{{%system_configs_group}}';

    /**
     * @var string
     */
    public $tableConfigsGroup = '{{%configs_group}}';

    /**
     * @var string
     */
    public $tableConfigsGroupLangNew = '{{%system_configs_group_lang}}';

    /**
     * @var string
     */
    public $tableConfigsGroupLang = '{{%configs_group_lang}}';

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
        $this->renameTable($this->tableConfigsParams, $this->tableConfigsParamsNew);
        $this->renameTable($this->tableConfigsParamsLang, $this->tableConfigsParamsLangNew);
        $this->renameTable($this->tableConfigsGroup, $this->tableConfigsGroupNew);
        $this->renameTable($this->tableConfigsGroupLang, $this->tableConfigsGroupLangNew);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameTable($this->tableConfigsParamsNew, $this->tableConfigsParams);
        $this->renameTable($this->tableConfigsParamsLangNew, $this->tableConfigsParamsLang);
        $this->renameTable($this->tableConfigsGroupNew, $this->tableConfigsGroup);
        $this->renameTable($this->tableConfigsGroupLangNew, $this->tableConfigsGroupLang);
    }

}
