<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031215_create_fv_menu_item_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_031215_create_fv_menu_item_table extends Migration
{

    /**
     * Menu table name
     * @var string
     */
    public $tableMenu = '{{%menu}}';

    /**
     * Menu item table name
     * @var string
     */
    public $tableMenuItem = '{{%menu_item}}';

    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->db = Menu::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableMenuItem, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('Group ID'),
            'parent_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Parent ID'),
            'type' => "enum('normal','divider','header') NOT NULL DEFAULT 'normal' COMMENT 'Type'",
            'link' => $this->string(255)->notNull()->defaultValue('')->comment('Link'),
            'link_type' => "enum('external','internal') NOT NULL DEFAULT 'external' COMMENT 'Link type'",
            'link_target' => "enum('_blank','_self') NOT NULL DEFAULT '_blank' COMMENT 'Link target'",
            'internal_source' => "enum('page') NOT NULL DEFAULT 'page' COMMENT 'Internal source'",
            'internal_source_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Internal Source ID'),
            'position' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('group_id', $this->tableMenuItem, 'group_id');
        $this->createIndex('published', $this->tableMenuItem, 'published');
        $this->createIndex('deleted', $this->tableMenuItem, 'deleted');

        $this->addForeignKey(
            'fk-menu_item-rid-menu-id',
            $this->tableMenuItem,
            'group_id',
            $this->tableMenu,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-menu_item-rid-menu-id', $this->tableMenuItem);
        $this->dropIndex('deleted', $this->tableMenuItem);
        $this->dropIndex('published', $this->tableMenuItem);
        $this->dropIndex('group_id', $this->tableMenuItem);
        $this->dropTable($this->tableMenuItem);
    }
}
