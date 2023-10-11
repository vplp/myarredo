<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190226_163256_update_catalog_italian_item_table extends Migration
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

    public function safeUp()
    {
        $this->addColumn(
            $this->table,
            'price_without_technology',
            $this
                ->float()
                ->defaultValue(0.00)
                ->after('price_new')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'price_without_technology');
    }
}
