<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121822_update_catalog_composition_many_item_table
 */
class m170721_121822_update_catalog_composition_many_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%composition_many_item}}';

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
        $this->renameColumn($this->table, 'item_id', 'catalog_item_id');

        $this->renameTable('composition_many_item', 'catalog_item_rel_composition');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_item_rel_composition', 'composition_many_item');

        $this->renameColumn($this->table, 'catalog_item_id', 'item_id');
    }
}
