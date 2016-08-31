<?php

use yii\db\Migration;

/**
 * Handles the creation for table `seo_table`.
 */
class m160704_103826_create_seo_table extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%seo}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePage, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'model_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('model id'),
            'model_namespace' => $this->string(255)->notNull()->defaultValue('')->comment('model_namespace'),
            'in_search' => $this->boolean()->notNull()->defaultValue(1)->comment('Отображать в поисковиках'),
            'in_robots' => $this->boolean()->notNull()->defaultValue(1)->comment('Отображать в robots.txt'),
            'in_site_map' => $this->boolean()->notNull()->defaultValue(1)->comment('Добавить в siteMap'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted')
        ]);

        $this->createIndex('published', $this->tablePage, 'published');
        $this->createIndex('deleted', $this->tablePage, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->tablePage);
        $this->dropIndex('published', $this->tablePage);
        $this->dropTable($this->tablePage);
    }
}
