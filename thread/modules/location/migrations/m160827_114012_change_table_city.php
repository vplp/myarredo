<?php

use yii\db\Migration;

/**
 * Class m160827_114012_change_table_city
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class m160827_114012_change_table_city extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tableCity = '{{%location_city}}';

    /**
     * @var string
     */
    public $tableCountry = '{{%location_country}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-location_city-location_country_id-location_country-id', $this->tableCity);
        $this->renameColumn($this->tableCity, 'location_country_id', 'country_id');

        $this->addForeignKey(
            'fk-location_city-country_id-location_country-id',
            $this->tableCity,
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
        $this->dropForeignKey('fk-location_city-country_id-location_country-id', $this->tableCity);
        $this->renameColumn($this->tableCity, 'country_id', 'location_country_id');

        $this->addForeignKey(
            'fk-location_city-location_country_id-location_country-id',
            $this->tableCity,
            'location_country_id',
            $this->tableCountry,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}
