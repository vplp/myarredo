<?php

use yii\db\Migration;
//
use common\modules\location\Location;

/**
 * Class m170929_150125_update_location_city_lang_table
 */
class m170929_150125_update_location_city_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $tableCityLang = '{{%location_city_lang}}';

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
        $this->addColumn($this->tableCityLang, 'title_where', $this->string(128)->defaultValue(null)->comment('title'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCityLang, 'title_where');
    }
}
