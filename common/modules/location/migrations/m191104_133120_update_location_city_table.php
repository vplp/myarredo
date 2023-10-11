<?php

use yii\db\Migration;
//
use common\modules\location\Location;

class m191104_133120_update_location_city_table extends Migration
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
        $this->addColumn($this->table, 'show_price', "enum('0','1') NOT NULL DEFAULT '1'");
        $this->createIndex('show_price', $this->table, 'show_price');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('show_price', $this->table);
        $this->dropColumn($this->table, 'show_price');
    }
}
