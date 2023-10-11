<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190227_162222_update_catalog_italian_item_table extends Migration
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
            'file_link',
            $this
                ->string(255)
                ->defaultValue(null)
                ->after('gallery_image')
        );
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'file_link');
    }
}
