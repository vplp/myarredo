<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191114_131544_update_catalog_factory_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_factory}}';

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
        $this->addColumn($this->table, 'product_count', $this->integer(11)->unsigned()->notNull()->defaultValue(0));
        $this->createIndex('product_count', $this->table, 'product_count');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('product_count', $this->table);
        $this->dropColumn($this->table, 'product_count');
    }
}
