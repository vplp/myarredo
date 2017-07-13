<?php

use yii\db\Migration;

/**
 * Class m170506_101632_create_table_seo_model_link
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170506_101632_create_table_seo_model_link extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_model_link}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'model_key' => $this->string(40)->notNull()->comment('model_key'),
            'model_id' => $this->integer()->unsigned()->notNull()->comment('model_id'),
            'lang' => $this->string(5)->notNull()->comment('lang'),
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

        $this->createIndex('model_key_2', $this->table, ['model_key', 'model_id', 'lang'], true);

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
        $this->createIndex('add_to_sitemap', $this->table, 'add_to_sitemap');
        $this->createIndex('dissallow_in_robotstxt', $this->table, 'dissallow_in_robotstxt');

        $this->createIndex('model_key', $this->table, 'model_key');
        $this->createIndex('model_id', $this->table, 'model_id');
        $this->createIndex('lang', $this->table, 'lang');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('model_key_2', $this->table);

        $this->dropIndex('published', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('add_to_sitemap', $this->table);
        $this->dropIndex('dissallow_in_robotstxt', $this->table);

        $this->dropIndex('model_key', $this->table);
        $this->dropIndex('model_id', $this->table);
        $this->dropIndex('lang', $this->table);
        $this->dropTable($this->table);
    }
}
