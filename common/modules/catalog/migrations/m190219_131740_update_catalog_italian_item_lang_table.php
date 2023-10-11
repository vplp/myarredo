<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190219_131740_update_catalog_italian_item_lang_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item_lang}}';

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
        $this->dropColumn($this->table, 'material');
    }

    public function safeDown()
    {
        $this->addColumn(
            $this->table,
            'material',
            $this
                ->string(1024)
                ->defaultValue(null)
        );
    }
}
