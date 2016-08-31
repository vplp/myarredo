<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160721_073703_insert_default_news
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160721_073703_insert_default_news extends Migration
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
     *
     */
    public function safeUp()
    {
        /** Insert news_group */
        $this->batchInsert(
            $this->tableNewsGroup,
            [
                'id',
                'alias',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'alias' => 'news',
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
            ]
        );

        /** Insert news_group_lang */
        $this->batchInsert(
            $this->tableNewsGroupLang,
            [
                'rid',
                'lang',
                'title',
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'News',
                ],
            ]
        );

        /** Insert news_article */
        $this->batchInsert(
            $this->tableNewsArticle,
            [
                'id',
                'group_id',
                'alias',
                'image_link',
                'published_time',
                'created_at',
                'updated_at',
                'published',
                'deleted',
            ],
            [
                [
                    'id' => 1,
                    'group_id' => 1,
                    'alias' => 'news1',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 2,
                    'group_id' => 1,
                    'alias' => 'news2',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 3,
                    'group_id' => 1,
                    'alias' => 'news3',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 4,
                    'group_id' => 1,
                    'alias' => 'news4',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 5,
                    'group_id' => 1,
                    'alias' => 'news5',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 6,
                    'group_id' => 1,
                    'alias' => 'news6',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
                [
                    'id' => 7,
                    'group_id' => 1,
                    'alias' => 'news7',
                    'image_link' => null,
                    'published_time' => time(),
                    'created_at' => time(),
                    'updated_at' => time(),
                    'published' => '1',
                    'deleted' => '0',
                ],
            ]
        );

        /** Insert news_article_lang */
        $this->batchInsert(
            $this->tableNewsArticleLang,
            [
                'rid',
                'lang',
                'title',
                'description',
                'content',
            ],
            [
                [
                    'rid' => 1,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП'
                ],
                [
                    'rid' => 2,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП'
                ],
                [
                    'rid' => 3,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП'
                ],
                [
                    'rid' => 4,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП'
                ],
                [
                    'rid' => 5,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП'
                ],
                [
                    'rid' => 6,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП...',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП...'
                ],
                [
                    'rid' => 7,
                    'lang' => 'en-EN',
                    'title' => 'ВЕНТС вошел в ТОП Национального бизнес рейтинга Украины',
                    'description' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП...',
                    'content' => '25 декабря 2015 года в столичном Концерт-холле Freedom состоялось торжественное награждение лидеров экономики, вошедших в ТОП...'
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->truncateTable($this->tableNewsArticleLang);
        $this->dropForeignKey('fk-news_article_lang-rid-news_article-id', $this->tableNewsArticleLang);


        $this->truncateTable($this->tableNewsArticle);
        $this->dropForeignKey('fk-news_article-group_id-news_group-id', $this->tableNewsArticle);


        $this->truncateTable($this->tableNewsGroupLang);
        $this->dropForeignKey('fk-news_group_lang-rid-news_group-id', $this->tableNewsGroupLang);

        $this->truncateTable($this->tableNewsGroup);

        $this->addForeignKey(
            'fk-news_article-group_id-news_group-id',
            $this->tableNewsArticle,
            'group_id',
            $this->tableNewsGroup,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_article_lang-rid-news_article-id',
            $this->tableNewsArticleLang,
            'rid',
            $this->tableNewsArticle,
            'id',
            'CASCADE',
            'CASCADE'
        );

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
}
