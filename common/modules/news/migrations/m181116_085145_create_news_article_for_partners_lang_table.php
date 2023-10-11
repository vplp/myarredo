<?php

use yii\db\Migration;
//
use common\modules\news\News;

/**
 * Handles the creation of table `news_article_for_partners_lang`.
 */
class m181116_085145_create_news_article_for_partners_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%news_article_for_partners}}';
    
    /**
     * table name
     * @var string
     */
    public $tableLang = '{{%news_article_for_partners_lang}}';

    /**
     * @inheritdoc
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
        $this->createTable($this->tableLang, [
            'rid' => $this->integer(11)->unsigned()->notNull()->comment('Related model ID'),
            'lang' => $this->string(5)->notNull()->comment('Language'),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'description' => $this->string(1024)->defaultValue(null)->comment('Description'),
            'content' => $this->text()->defaultValue(null)->comment('Content'),
        ]);
        $this->createIndex('rid', $this->tableLang, ['rid', 'lang'], true);
        $this->addForeignKey(
            'fk-article_for_partners_lang-rid-article_for_partners-id',
            $this->tableLang,
            'rid',
            $this->table,
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
        $this->dropForeignKey('fk-article_for_partners_lang-rid-article_for_partners-id', $this->tableLang);
        $this->dropIndex('rid', $this->tableLang);
        $this->dropTable($this->tableLang);
    }
}
