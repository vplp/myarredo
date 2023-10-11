<?php

use yii\db\Migration;
//
use common\modules\location\Location;

class m180129_134918_update_location_country_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%location_country}}';

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
        $this->addColumn($this->table, 'bookId', $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('bookId in SendPulse')->after('id'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'bookId');
    }
}
