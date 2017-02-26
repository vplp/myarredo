<?php

use yii\db\Migration;
use thread\modules\sys\Sys as SysModule;

/**
 * Class m161115_145426_rename_default_to_by_default
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161115_145426_rename_default_to_by_default extends Migration
{

    /**
     * @var string
     */
    public $tableLanguages = '{{%system_languages}}';

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
        $this->execute('ALTER TABLE '.$this->tableLanguages.' CHANGE `default` `by_default` ENUM(\'0\', \'1\') NOT NULL DEFAULT \'0\' COMMENT \'by_default\';');
        $this->createIndex('by_default', $this->tableLanguages, 'by_default');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }

}
