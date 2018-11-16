<?php

use yii\db\Migration;
//
use common\modules\news\News;

/**
 * Handles the creation of table `news_article_for_partners`.
 */
class m181116_085136_create_news_article_for_partners_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%news_article_for_partners}}';

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
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'position' => $this->integer(11)->unsigned()->defaultValue(0),
            'show_all' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'created_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
        $this->createIndex('show_all', $this->table, 'show_all');
        $this->createIndex('position', $this->table, 'position');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('position', $this->table);
        $this->dropIndex('show_all', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);

        $this->dropTable($this->table);
    }
}
