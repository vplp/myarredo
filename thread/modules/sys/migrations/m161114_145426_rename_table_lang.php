<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m160810_145426_insert_table_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161114_145426_rename_table_lang extends Migration
{

    /**
     * @var string
     */
    public $tableLanguagesNew = '{{%system_languages}}';

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
        $this->renameTable($this->tableLanguages, $this->tableLanguagesNew);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->renameTable($this->tableLanguagesNew, $this->tableLanguages);
    }

}
