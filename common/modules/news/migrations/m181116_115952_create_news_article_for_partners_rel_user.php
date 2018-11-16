<?php

use yii\db\Migration;
//
use common\modules\news\News;

class m181116_115952_create_news_article_for_partners_rel_user extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%news_article_for_partners_rel_user}}';

    /**
     * @var string
     */
    public $tableUser = '{{%user}}';

    /**
     * @var string
     */
    public $tableArticle = '{{%news_article_for_partners}}';

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
        $this->createTable($this->tableRel, [
            'article_id' => $this->integer(11)->unsigned()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_article_id', $this->tableRel, 'article_id');
        $this->createIndex('idx_user_id', $this->tableRel, 'user_id');
        $this->createIndex('idx_article_id_user_id', $this->tableRel, ['article_id', 'user_id'], true);

        $this->addForeignKey(
            'fk-news_article_for_partners_rel_user_ibfk_1',
            $this->tableRel,
            'article_id',
            $this->tableArticle,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_article_for_partners_rel_user_ibfk_2',
            $this->tableRel,
            'user_id',
            $this->tableUser,
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
        $this->dropForeignKey('fk-news_article_for_partners_rel_user_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-news_article_for_partners_rel_user_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_article_id_user_id', $this->tableRel);
        $this->dropIndex('idx_user_id', $this->tableRel);
        $this->dropIndex('idx_article_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
