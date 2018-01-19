<?php

use yii\db\Migration;
//
use common\modules\location\Location;

class m180119_104257_update_location_city_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%location_city}}';

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
        $this->addColumn($this->table, 'geo_placename', $this->string(255)->defaultValue(null)->after('lng'));
        $this->addColumn($this->table, 'geo_position', $this->string(255)->defaultValue(null)->after('geo_placename'));
        $this->addColumn($this->table, 'geo_region', $this->string(255)->defaultValue(null)->after('geo_position'));
        $this->addColumn($this->table, 'icbm', $this->string(255)->defaultValue(null)->after('geo_region'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'icbm');
        $this->dropColumn($this->table, 'geo_region');
        $this->dropColumn($this->table, 'geo_position');
        $this->dropColumn($this->table, 'geo_placename');
    }
}
