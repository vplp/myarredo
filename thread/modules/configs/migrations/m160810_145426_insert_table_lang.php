<?php

use yii\db\Migration;
use thread\modules\configs\Configs as ConfigsModule;

/**
 * Class m160810_145426_insert_table_lang
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160810_145426_insert_table_lang extends Migration
{
    /**
     *
     */
    public function init()
    {
        $this->db = ConfigsModule::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_languages', 'default', $this->integer()->defaultValue(null)->comment('default'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_languages', 'default');
    }

}
