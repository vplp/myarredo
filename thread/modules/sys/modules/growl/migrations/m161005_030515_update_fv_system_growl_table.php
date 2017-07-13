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
 * Class m161005_030515_update_fv_system_growl_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m161005_030515_update_fv_system_growl_table extends Migration
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
        $this->execute("ALTER TABLE `fv_system_growl` CHANGE `type` `type` ENUM('notice','warning','error','danger', 'success', 'primary') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'notice' COMMENT 'Type'");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->execute("ALTER TABLE `fv_system_growl` CHANGE `type` `type` ENUM('notice','warning','error') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'notice' COMMENT 'Type'");
    }
}
