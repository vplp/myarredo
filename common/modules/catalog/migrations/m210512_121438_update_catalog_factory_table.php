<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m210512_121438_update_catalog_factory_table extends Migration
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
        $this->addColumn($this->table, 'show_catalogs_files', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->createIndex('show_catalogs_files', $this->table, 'show_catalogs_files');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('show_catalogs_files', $this->table);
        $this->dropColumn($this->table, 'show_catalogs_files');
    }
}
