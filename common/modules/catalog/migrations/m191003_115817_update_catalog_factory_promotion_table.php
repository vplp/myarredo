<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191003_115817_update_catalog_factory_promotion_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory_promotion}}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->db = Catalog::getDb();
        parent::init();
    }

    public function safeUp()
    {
        $this->alterColumn($this->table, 'status', "enum('not_active','active','completed') NOT NULL DEFAULT 'not_active'");
    }

    public function safeDown()
    {
        $this->alterColumn($this->table, 'status', "enum('0','1') NOT NULL DEFAULT '0'");
    }
}
