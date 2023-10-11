<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121922_update_catalog_item_many_group_table
 */
class m170721_121922_update_catalog_item_many_group_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_many_group}}';

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
        $this->renameColumn($this->table, 'catalog_id', 'catalog_item_id');

        $this->renameTable('catalog_many_group', 'catalog_item_rel_catalog_group');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_item_rel_catalog_group', 'catalog_many_group');

        $this->renameColumn($this->table, 'catalog_item_id', 'catalog_id');
    }
}
