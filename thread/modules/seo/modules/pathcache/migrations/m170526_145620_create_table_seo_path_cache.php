<?php

use yii\db\Migration;

/**
 * Class m170526_145620_create_table_seo_path_cache
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170526_145620_create_table_seo_path_cache extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_path_cache}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'model_key' => $this->string(40)->defaultValue(null)->comment('model_key'),
            'classname' => $this->string(255)->unique()->defaultValue(null)->comment('classname'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('model_key', $this->table, 'model_key');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('model_key', $this->table);
        $this->dropIndex('classname', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropTable($this->table);
    }
}
