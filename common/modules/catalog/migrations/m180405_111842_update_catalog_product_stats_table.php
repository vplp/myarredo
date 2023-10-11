<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180405_111842_update_catalog_product_stats_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item_stats}}';

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
        $this->addColumn($this->table, 'is_bot', "enum('0','1') NOT NULL DEFAULT '0' AFTER ip");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'is_bot');
    }
}
