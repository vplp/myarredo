<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160127_030525_create_fv_news_group_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_030525_create_fv_news_group_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tableNewsGroup = '{{%news_group}}';

    /**
     * @var string
     */
    public $tableNewsGroupLang = '{{%news_group_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = News::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableNewsGroupLang, [
            'rid' => $this->integer()->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
        ]);
        
        $this->createIndex('rid', $this->tableNewsGroupLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-news_group_lang-rid-news_group-id',
            $this->tableNewsGroupLang,
            'rid',
            $this->tableNewsGroup,
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
        $this->dropForeignKey('fk-news_group_lang-rid-news_group-id', $this->tableNewsGroupLang);
        $this->dropIndex('rid', $this->tableNewsGroupLang);
        $this->dropTable($this->tableNewsGroupLang);
    }
}
