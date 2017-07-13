<?php

use yii\db\Migration;

/**
 * Class m160705_094012_create_table_country
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_094012_create_table_country extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%location_country}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable($this->tablePage, [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'alias' => $this->string(128)->notNull()->unique()->comment('alias'),
            'title' => $this->string(128)->defaultValue(null)->comment('title'),
            'alpha2' => $this->string(2)->defaultValue(null)->comment('alpha2'),
            'alpha3' => $this->string(3)->defaultValue(null)->comment('alpha3'),
            'iso' => $this->string(3)->defaultValue(null)->comment('iso'),
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
