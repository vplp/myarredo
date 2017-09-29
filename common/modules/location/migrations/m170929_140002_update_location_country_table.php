<?php

use yii\db\Migration;
//
use common\modules\location\Location;

/**
 * Class m170929_140002_update_location_country_table
 */
class m170929_140002_update_location_country_table extends Migration
{
    /**
     * table name
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
        $this->addColumn($this->tableCountry, 'position', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('Position'));

        $this->dropColumn($this->tableCountry, 'title');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->tableCountry, 'title', $this->string(128)->defaultValue(null)->comment('title')->after('id'));

        $this->dropColumn($this->tableCountry, 'position');
    }
}
