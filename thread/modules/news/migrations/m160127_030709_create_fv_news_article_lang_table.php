<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160127_030709_create_fv_news_article_lang_table
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160127_030709_create_fv_news_article_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tableNewsArticle = '{{%news_article}}';

    /**
     * @var string
     */
    public $tableNewsArticleLang = '{{%news_article_lang}}';

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
        $this->createTable($this->tableNewsArticleLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'description' => $this->string(255)->defaultValue(null)->comment('Description'),
            'content' => $this->text()->defaultValue(null)->comment('Content'),
        ]);
        $this->createIndex('rid', $this->tableNewsArticleLang, ['rid', 'lang'], true);
        $this->addForeignKey(
            'fk-news_article_lang-rid-news_article-id',
            $this->tableNewsArticleLang,
            'rid',
            $this->tableNewsArticle,
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
        $this->dropForeignKey('fk-news_article_lang-rid-news_article-id', $this->tableNewsArticleLang);
        $this->dropIndex('rid', $this->tableNewsArticleLang);
        $this->dropTable($this->tableNewsArticleLang);
    }
}
