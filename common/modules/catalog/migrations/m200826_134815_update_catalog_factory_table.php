<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200826_134815_update_catalog_factory_table extends Migration
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
        $this->addColumn($this->table, 'show_for_kz', "enum('0','1') NOT NULL DEFAULT '0' AFTER show_for_de");
        $this->createIndex('show_for_kz', $this->table, 'show_for_kz');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'show_for_kz');
        $this->dropIndex('show_for_kz', $this->table);
    }
}
