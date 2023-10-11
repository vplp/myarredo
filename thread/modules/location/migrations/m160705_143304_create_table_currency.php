<?php

use yii\db\Migration;

/**
 * Class m160705_143304_create_table_currency
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_143304_create_table_currency extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $table = '{{%location_currency}}';


    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'alias' => $this->string(128)->notNull()->unique()->comment('alias'),
                'code1' => $this->string(4)->notNull()->defaultValue('')->comment('code1'),
                'code2' => $this->string(4)->notNull()->defaultValue('')->comment('code2'),
                'title' => $this->string(255)->notNull()->defaultValue('')->comment('title'),
                'course' => $this->decimal(10, 3)->notNull()->defaultValue(1.000)->comment('course'),
                'currency_symbol' => $this->string(255)->notNull()->defaultValue('')->comment('currency_symbol'),
                'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
                'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
                'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
                'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted')
            ]
        );

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropTable($this->table);
    }
}
