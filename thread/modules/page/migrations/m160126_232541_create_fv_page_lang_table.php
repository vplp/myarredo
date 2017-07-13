<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_232541_create_fv_page_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160126_232541_create_fv_page_lang_table extends Migration
{

    /**
     * Related Page table name
     * @var string
     */
    public $tablePage = '{{%page}}';

    /**
     * Language Page table name
     * @var string
     */
    public $tablePageLang = '{{%page_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Page::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePageLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'content' => $this->text()->defaultValue(null)->comment('Content')
        ]);

        $this->createIndex('rid', $this->tablePageLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-page_lang-rid-page-id',
            $this->tablePageLang,
            'rid',
            $this->tablePage,
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
        $this->dropForeignKey('fk-page_lang-rid-page-id', $this->tablePageLang);
        $this->dropIndex('rid', $this->tablePageLang);
        $this->dropTable($this->tablePageLang);
    }
}
