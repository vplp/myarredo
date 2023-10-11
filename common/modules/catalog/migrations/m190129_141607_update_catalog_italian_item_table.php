<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190129_141607_update_catalog_italian_item_table extends Migration
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
            'weight',
            $this
                ->float()
                ->defaultValue(0)
                ->after('volume')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'weight');
    }
}
