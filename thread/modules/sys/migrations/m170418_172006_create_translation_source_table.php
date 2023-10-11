<?php

use yii\db\Migration;

/**
 * Class m170418_172006_create_translation_source_table
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 */
class m170418_172006_create_translation_source_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%translation_source}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned()->comment('Id'),
                'key' => $this->string()->unique()->notNull()->comment('Key'),
                'category' => $this->string()->notNull()->defaultValue('')->comment('Category'),
                'created_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Create time'),
                'updated_at' => $this->integer(10)->notNull()->defaultValue(0)->comment('Update time'),
                'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
                'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted'),
            ]
        );

        $this->createIndex('translation_key', $this->table, 'key');
        $this->createIndex('category', $this->table, 'category');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex('translation_key', $this->table);
        $this->dropIndex('category', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('deleted', $this->table);
        $this->dropTable($this->table);
    }
}
