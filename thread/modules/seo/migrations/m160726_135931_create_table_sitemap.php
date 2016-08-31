<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_sitemap`.
 */
class m160726_135931_create_table_sitemap extends Migration
{

    public $tableName = '{{%seo_sitemap_element}}';

    public function init()
    {
        $this->db = \thread\modules\seo\Seo::getDb();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'module_id' => $this->string(255)->notNull()->comment('Module ID'),
            'model_id' => $this->string(255)->notNull()->comment('Model ID'),
            'key' => $this->string(50)->notNull()->comment('Key'),
            'url' => $this->text()->notNull()->comment('Url'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
            'readonly' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
        ]);
        $this->createIndex('published', $this->tableName, 'published');
        $this->createIndex('deleted', $this->tableName, 'deleted');
        $this->createIndex('module_id', $this->tableName, 'module_id');
        $this->createIndex('model_id', $this->tableName, 'model_id');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('published', $this->tableName);
        $this->dropIndex('deleted', $this->tableName);
        $this->dropIndex('module_id', $this->tableName);
        $this->dropIndex('model_id', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
