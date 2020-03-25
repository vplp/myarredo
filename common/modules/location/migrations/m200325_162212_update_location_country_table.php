<?php

use yii\db\Migration;
use common\modules\location\Location as ParentModule;

class m200325_162212_update_location_country_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%location_country}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = ParentModule::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'show_for_registration', "enum('0','1') NOT NULL DEFAULT '0' AFTER iso");
        $this->addColumn($this->table, 'show_for_filter', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_registration");

        $this->createIndex('show_for_registration', $this->table, 'show_for_registration');
        $this->createIndex('show_for_filter', $this->table, 'show_for_filter');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('show_for_filter', $this->table);
        $this->dropIndex('show_for_registration', $this->table);

        $this->dropColumn($this->table, 'show_for_filter');
        $this->dropColumn($this->table, 'show_for_registration');
    }
}
