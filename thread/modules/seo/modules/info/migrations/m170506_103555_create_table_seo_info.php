<?php

use yii\db\Migration;

/**
 * Class m170506_103555_create_table_seo_info
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m170506_103555_create_table_seo_info extends Migration
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = '{{%seo_info}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(255)->notNull()->comment('alias'),
            'default_title' => $this->string(255)->defaultValue('')->comment('Default title'),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('created_at'),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('updated_at'),
            'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'published'",
            'deleted' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'deleted'"
        ]);

        $this->createIndex('alias', $this->table, 'alias', true);
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('alias', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropTable($this->table);
    }
}
