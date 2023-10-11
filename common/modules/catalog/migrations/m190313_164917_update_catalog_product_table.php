<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190313_164917_update_catalog_product_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_item}}';

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
        $this->addColumn($this->table, 'currency', "enum('EUR','RUB') NOT NULL DEFAULT 'EUR' AFTER price_from");
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'currency');
    }
}
