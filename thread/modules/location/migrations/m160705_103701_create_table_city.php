<?php

use yii\db\Migration;

/**
 * Class m160705_103701_create_table_city
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160705_103701_create_table_city extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tablePage = '{{%location_city}}';


    public $tableCountry = '{{%location_country}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tablePage,
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'alias' => $this->string(128)->notNull()->unique()->comment('alias'),
                'location_country_id' => $this->integer()->unsigned()->comment('location_country_id'),
                'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Create time'),
                'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Update time'),
                'published' => "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Published'",
                'deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('Deleted')
            ]
        );

        $this->createIndex('published', $this->tablePage, 'published');
        $this->createIndex('deleted', $this->tablePage, 'deleted');

        $this->addForeignKey(
            'fk-location_city-location_country_id-location_country-id',
            $this->tablePage,
            'location_country_id',
            $this->tableCountry,
            'id',
            'CASCADE',
            'CASCADE'
        );


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
