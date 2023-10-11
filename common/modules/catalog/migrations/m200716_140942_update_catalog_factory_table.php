<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200716_140942_update_catalog_factory_table extends Migration
{

    /**
    * @var string
    */
    public $table = '{{%catalog_factory}}';

    /**
    *
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
        $this->addColumn($this->table, 'show_for_de', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_com");
        $this->createIndex('show_for_de', $this->table, 'show_for_de');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'show_for_de');
        $this->dropIndex('show_for_de', $this->table);
    }
}
