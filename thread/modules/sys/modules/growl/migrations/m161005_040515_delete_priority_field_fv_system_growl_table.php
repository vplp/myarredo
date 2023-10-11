<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>

<?php

use yii\db\Migration;
use thread\modules\sys\Sys;

/**
 * Class m161005_040515_delete_priority_field_fv_system_growl_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161005_040515_delete_priority_field_fv_system_growl_table extends Migration
{
    /**
     * @var string
     */
    public $tableSysGrowl = '{{%system_growl}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Sys::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableSysGrowl, 'priority');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->tableSysGrowl, 'priority', $this->integer()->notNull()->comment('Priority'));
    }
}
