<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170731_141922_update_catalog_sale_many_group_table
 */
class m170731_141922_update_catalog_sale_many_group_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%sale_catalog_many_group}}';

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
        $this->renameColumn($this->table, 'sale_catalog_item_id', 'sale_item_id');
        $this->renameColumn($this->table, 'catalog_group_id', 'group_id');

        $this->renameTable('sale_catalog_many_group', 'catalog_sale_item_rel_catalog_group');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_sale_item_rel_catalog_group', 'sale_catalog_many_group');

        $this->renameColumn($this->table, 'group_id', 'catalog_group_id');
        $this->renameColumn($this->table, 'sale_item_id', 'sale_catalog_item_id');
    }
}
