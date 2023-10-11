<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m181217_185923_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'show_for_ru', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->addColumn($this->table, 'show_for_by', "enum('0','1') NOT NULL DEFAULT '0'");
        $this->addColumn($this->table, 'show_for_ua', "enum('0','1') NOT NULL DEFAULT '0'");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'show_for_ua');
        $this->dropColumn($this->table, 'show_for_by');
        $this->dropColumn($this->table, 'show_for_ru');
    }
}
