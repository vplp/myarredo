<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m231004_065618_update_catalog_factory_table extends Migration
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
        $this->addColumn($this->table, 'show_for_uk', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_com");
        $this->addColumn($this->table, 'show_for_fr', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_uk");
        $this->createIndex('show_for_uk', $this->table, 'show_for_uk');
        $this->createIndex('show_for_fr', $this->table, 'show_for_fr');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {      
        $this->dropIndex('show_for_uk', $this->table);
        $this->dropColumn($this->table, 'show_for_uk');
        $this->dropIndex('show_for_fr', $this->table);
        $this->dropColumn($this->table, 'show_for_fr');
    }
}
