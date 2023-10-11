<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190612_134649_update_catalog_sale_request extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item_request}}';

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
        $this->addColumn($this->table, 'offer_price', $this->float()->defaultValue(0)->after('city_id'));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'offer_price');
    }
}
