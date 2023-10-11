<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190405_140334_update_catalog_italian_item_table extends Migration
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

        $this->dropColumn($this->table, 'region');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->addColumn($this->table, 'region', $this->string(255)->defaultValue(null));
    }
}
