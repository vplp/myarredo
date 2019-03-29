<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190131_131740_update_catalog_italian_item_lang_table extends Migration
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
        $this->addColumn(
            $this->table,
            'defects',
            $this
                ->string(1024)
                ->defaultValue(null)
        );
        $this->addColumn(
            $this->table,
            'material',
            $this
                ->string(1024)
                ->defaultValue(null)
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'material');
        $this->dropColumn($this->table, 'defects');
    }
}
