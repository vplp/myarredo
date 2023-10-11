<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180202_141832_update_catalog_factory_table extends Migration
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
        $this->addColumn($this->table, 'new_price', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'new_price'");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'new_price');
    }
}
