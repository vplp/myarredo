<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190131_131607_update_catalog_italian_item_table extends Migration
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
            'production_year',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('weight')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'production_year');
    }
}
