<?php

use yii\db\Migration;
//
use common\modules\location\Location;

/**
 * Class m170929_140015_update_location_city_table
 */
class m170929_140015_update_location_city_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableCity = '{{%location_city}}';

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
        $this->addColumn($this->tableCity, 'position', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'));
        $this->addColumn($this->tableCity, 'lat', $this->float()->defaultValue(0)->comment('lat')->after('country_id'));
        $this->addColumn($this->tableCity, 'lng', $this->float()->defaultValue(0)->comment('lng')->after('lat'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCity, 'lat');
        $this->dropColumn($this->tableCity, 'lng');
        $this->dropColumn($this->tableCity, 'position');
    }
}
