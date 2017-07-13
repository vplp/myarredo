<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031223_create_fv_menu_item_lang_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_031223_create_fv_menu_item_lang_table extends Migration
{

    /**
     * Menu item table name
     * @var string
     */
    public $tableMenuItem = '{{%menu_item}}';

    /**
     * Menu item language table name
     * @var string
     */
    public $tableMenuItemLang = '{{%menu_item_lang}}';

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
        $this->createTable($this->tableMenuItemLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableMenuItemLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-menu_item_lang-rid-menu_item-id',
            $this->tableMenuItemLang,
            'rid',
            $this->tableMenuItem,
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
        $this->dropForeignKey('fk-menu_item_lang-rid-menu_item-id', $this->tableMenuItemLang);
        $this->dropIndex('rid', $this->tableMenuItemLang);
        $this->dropTable($this->tableMenuItemLang);
    }
}
