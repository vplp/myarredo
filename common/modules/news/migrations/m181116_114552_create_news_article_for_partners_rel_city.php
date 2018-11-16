<?php

use yii\db\Migration;
//
use common\modules\news\News;

class m181116_114552_create_news_article_for_partners_rel_city extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%news_article_for_partners_rel_city}}';

    /**
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
            'city_id' => $this->integer(11)->unsigned()->notNull(),
        ]);

        $this->createIndex('idx_article_id', $this->tableRel, 'article_id');
        $this->createIndex('idx_city_id', $this->tableRel, 'city_id');
        $this->createIndex('idx_article_id_city_id', $this->tableRel, ['article_id', 'city_id'], true);

        $this->addForeignKey(
            'fk-news_article_for_partners_rel_city_ibfk_1',
            $this->tableRel,
            'article_id',
            $this->tableArticle,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_article_for_partners_rel_city_ibfk_2',
            $this->tableRel,
            'city_id',
            $this->tableCity,
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
        $this->dropForeignKey('fk-news_article_for_partners_rel_city_ibfk_2', $this->tableRel);
        $this->dropForeignKey('fk-news_article_for_partners_rel_city_ibfk_1', $this->tableRel);

        $this->dropIndex('idx_article_id_city_id', $this->tableRel);
        $this->dropIndex('idx_city_id', $this->tableRel);
        $this->dropIndex('idx_article_id', $this->tableRel);

        $this->dropTable($this->tableRel);
    }
}
