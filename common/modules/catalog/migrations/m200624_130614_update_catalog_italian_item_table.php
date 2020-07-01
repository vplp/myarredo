<?php

use yii\db\Migration;
use common\modules\catalog\Catalog as ParentModule;

class m200624_130614_update_catalog_italian_item_table extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
        $this->addColumn($this->table, 'isGrezzo', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Grezzo'");
        $this->createIndex('isGrezzo', $this->table, 'isGrezzo');

        $this->addColumn($this->table, 'production_time', $this->string(255)->defaultValue(null));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('isGrezzo', $this->table);
        $this->dropColumn($this->table, 'isGrezzo');

        $this->dropColumn($this->table, 'production_time');
    }
}
