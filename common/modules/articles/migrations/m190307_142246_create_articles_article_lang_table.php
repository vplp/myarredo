<?php

use yii\db\Migration;
use common\modules\articles\Articles;

/**
 * Handles the creation of table `{{%articles_article_lang}}`.
 */
class m190307_142246_create_articles_article_lang_table extends Migration
{
    /**
     * @var string
     */
    public $tableArticle = '{{%articles_article}}';

    /**
     * @var string
     */
    public $tableArticleLang = '{{%articles_article_lang}}';

    /**
     *
     */
    public function init()
    {
        $this->db = Articles::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tableArticleLang, [
            'rid' => $this->integer(11)->unsigned()->notNull(),
            'lang' => $this->string(5)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255)->defaultValue(null),
            'content' => $this->text()->defaultValue(null),
        ]);

        $this->createIndex('rid', $this->tableArticleLang, ['rid', 'lang'], true);

        $this->addForeignKey(
            'fk-articles_article_lang-rid-articles_article-id',
            $this->tableArticleLang,
            'rid',
            $this->tableArticle,
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
        $this->dropForeignKey('fk-articles_article_lang-rid-articles_article-id', $this->tableArticleLang);

        $this->dropIndex('rid', $this->tableArticleLang);

        $this->dropTable($this->tableArticleLang);
    }
}
