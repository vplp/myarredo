<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 *
 * Class m160127_031136_create_fv_menu_lang_table
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_031136_create_fv_menu_lang_table extends Migration
{

    /**
     * Menu table name
     * @var string
     */
    public $tableMenu = '{{%menu}}';

    /**
     * Menu language table name
     * @var string
     */
    public $tableMenuLang = '{{%menu_lang}}';

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
        $this->createTable($this->tableMenuLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);

        $this->createIndex('rid', $this->tableMenuLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-menu_lang-rid-menu-id',
            $this->tableMenuLang,
            'rid',
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
        $this->dropForeignKey('fk-menu_lang-rid-menu-id', $this->tableMenuLang);
        $this->dropIndex('rid', $this->tableMenuLang);
        $this->dropTable($this->tableMenuLang);
    }
}
