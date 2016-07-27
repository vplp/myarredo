<?php

use yii\db\Migration;

class m160726_144344_create_table_location_company extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $table = '{{%location_company}}';


    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'country_id' => $this->integer(11)->unsigned()->notNull()->comment('country_id'),
                'city_id' => $this->integer(11)->unsigned()->notNull()->comment('city_id'),

                'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
                'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
                'published' => $this->boolean()->notNull()->defaultValue(0)->comment('Published'),
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
