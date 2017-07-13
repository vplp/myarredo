<?php

use yii\db\Migration;

/**
 * Class m160721_144902_menu_item_field_internal_source_update
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160721_144902_menu_item_field_internal_source_update extends Migration
{
    /**
     * Menu item table name
     * @var string
     */
    public $tableMenuItem = '{{%menu_item}}';

    /**
     *
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE `fv_menu_item` CHANGE `internal_source` `internal_source` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'page_page' COMMENT 'Internal source'");
    }

    /**
     *
     */
    public function safeDown()
    {

    }
}
