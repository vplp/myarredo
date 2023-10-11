<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191224_135812_update_catalog_sale_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item}}';

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
        $this->addColumn(
            $this->table,
            'is_sold',
            "enum('0','1') NOT NULL DEFAULT '0' after on_main"
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'is_sold');
    }
}
