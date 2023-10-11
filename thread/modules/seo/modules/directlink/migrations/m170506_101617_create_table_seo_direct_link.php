<?php

use yii\db\Migration;

/**
 * Class m170506_101617_create_table_seo_direct_link
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170506_101617_create_table_seo_direct_link extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_direct_link}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'url' => $this->string(128)->defaultValue(null)->comment('Url'),
            'meta_robots' => "enum('1','2', '3', '4') NOT NULL DEFAULT '1' COMMENT 'meta_robots'",
            'add_to_sitemap' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'add_to_sitemap'",
            'dissallow_in_robotstxt' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'dissallow_in_robotstxt'",
            'title' => $this->string(255)->notNull()->comment('Title'),
            'description' => $this->string(255)->notNull()->comment('description'),
            'keywords' => $this->string(255)->notNull()->comment('keywords'),
            'image_url' => $this->string(255)->notNull()->comment('image_url'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('url', $this->table, 'url');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
        $this->createIndex('add_to_sitemap', $this->table, 'add_to_sitemap');
        $this->createIndex('dissallow_in_robotstxt', $this->table, 'dissallow_in_robotstxt');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('url', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('add_to_sitemap', $this->table);
        $this->dropIndex('dissallow_in_robotstxt', $this->table);
        $this->dropTable($this->table);
    }
}
