<?php

use yii\db\Migration;
use common\modules\articles\Articles;

/**
 * Handles the creation of table `{{%articles_article}}`.
 */
class m190307_142237_create_articles_article_table extends Migration
{
    /**
     * @var string
     */
    public $tableArticle = '{{%articles_article}}';

    /**
     * @var string
     */
    public $tableCategory = '{{%catalog_group}}';

    /**
     * @var string
     */
    public $tableFactory = '{{%catalog_factory}}';

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
        $this->createTable($this->tableArticle, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->unique()->notNull(),
            'category_id' => $this->integer(11)->unsigned()->notNull(),
            'factory_id' => $this->integer(11)->unsigned()->notNull(),
            'image_link' => $this->string(255)->defaultValue(null),
            'published_time' => $this->integer(10)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0'",
        ]);

        $this->createIndex('published', $this->tableArticle, 'published');
        $this->createIndex('deleted', $this->tableArticle, 'deleted');
        $this->createIndex('published_time', $this->tableArticle, 'published_time');
        $this->createIndex('category_id', $this->tableArticle, 'category_id');
        $this->createIndex('factory_id', $this->tableArticle, 'factory_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('factory_id', $this->tableArticle);
        $this->dropIndex('category_id', $this->tableArticle);
        $this->dropIndex('published_time', $this->tableArticle);
        $this->dropIndex('deleted', $this->tableArticle);
        $this->dropIndex('published', $this->tableArticle);

        $this->dropTable($this->tableArticle);
    }
}
