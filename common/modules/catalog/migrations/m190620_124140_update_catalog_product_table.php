<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190620_124140_update_catalog_product_table extends Migration
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
        $this->addColumn($this->table, 'language_editing', $this->string(5)->defaultValue(null)->after('mark'));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'language_editing');
    }
}
