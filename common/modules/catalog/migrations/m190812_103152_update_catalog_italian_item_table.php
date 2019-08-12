<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190812_103152_update_catalog_italian_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
            'create_mode',
            "enum('paid','free') NOT NULL DEFAULT 'paid' after language_editing"
        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'create_mode');
    }
}
