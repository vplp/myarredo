<?php

use yii\db\Migration;

/**
 * Class m170408_144902_menu_item_field_source_type_update
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170408_144902_menu_item_field_source_type_update extends Migration
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
        $this->execute("ALTER TABLE `fv_menu_item` CHANGE `link_type` `link_type` ENUM('external','internal', 'permanent') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'external' COMMENT 'Link type';");
    }

    /**
     *
     */
    public function safeDown()
    {

    }
}
