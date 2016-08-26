<?php

use yii\db\Migration;

/**
 * m160827_114012_change_table_city
 */
class m160827_114012_change_table_city extends Migration
{
    /**
     * Page table name
     * @var string
     */
    public $tableCity = '{{%location_city}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->renameColumn($this->tableCity, 'location_country_id', 'country_id');
    }


    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->tableCity, 'country_id', 'location_country_id');
    }
}
