<?php

use yii\db\Migration;
use thread\modules\news\News;

/**
 * Class m160127_030515_create_fv_news_group_table
 *
 * @package thread\modules\news
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @copyright (c) 2016, VipDesign
 */
class m160127_030655_create_fv_news_article_table extends Migration
{
    /**
     * @var string
     */
    public $tableNewsArticle = '{{%news_article}}';

    /**
     * @var string
     */
    public $tableNewsGroup = '{{%news_group}}';

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
        $this->createTable($this->tableNewsArticle, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('Related group'),
            'alias' => $this->string(255)->unique()->notNull()->comment('Alias'),
            'image_link' => $this->string(255)->defaultValue(null)->comment('Image link'),
            'published_time' => $this->integer(10)->notNull()->defaultValue(0)->comment('Published time'),
            'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
            'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
        ]);
        $this->createIndex('published', $this->tableNewsArticle, 'published');
        $this->createIndex('deleted', $this->tableNewsArticle, 'deleted');
        $this->createIndex('published_time', $this->tableNewsArticle, 'published_time');
        $this->createIndex('group_id', $this->tableNewsArticle, 'group_id');
        $this->addForeignKey(
            'fk-news_article-group_id-news_group-id',
            $this->tableNewsArticle,
            'group_id',
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
        $this->dropForeignKey('fk-news_article-group_id-news_group-id', $this->tableNewsArticle);
        $this->dropIndex('group_id', $this->tableNewsArticle);
        $this->dropIndex('published_time', $this->tableNewsArticle);
        $this->dropIndex('deleted', $this->tableNewsArticle);
        $this->dropIndex('published', $this->tableNewsArticle);
        $this->dropTable($this->tableNewsArticle);
    }
}
