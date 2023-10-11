<?php

use yii\db\Migration;
//
use common\modules\location\Location;

/**
 * Handles the creation of table `{{%location_region}}`.
 */
class m190329_105207_create_location_region_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%location_region}}';

    /**
     * @var string
     */
    public $tableCountry = '{{%location_country}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Location::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned()->comment('ID'),
                'alias' => $this->string(225)->notNull()->unique(),
                'country_id' => $this->integer(11)->unsigned()->notNull(),
                'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
                'published' => "enum('0','1') NOT NULL DEFAULT '0'",
                'deleted' => "enum('0','1') NOT NULL DEFAULT '0'",
            ]
        );

        $this->createIndex('country_id', $this->table, 'country_id');
        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');

        $this->addForeignKey(
            'fk-location_region-location_country_id-country-id',
            $this->table,
            'country_id',
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
        $this->dropForeignKey('fk-location_region-location_country_id-country-id', $this->table);

        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropIndex('country_id', $this->table);

        $this->dropTable($this->table);
    }
}
