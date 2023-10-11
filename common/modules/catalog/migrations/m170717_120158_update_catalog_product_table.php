<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170717_120158_update_catalog_product_table
 */
class m170717_120158_update_catalog_product_table extends Migration
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
        $this->renameColumn($this->table, 'enabled', 'published');
        $this->renameColumn($this->table, 'created', 'created_at');
        $this->renameColumn($this->table, 'updated', 'updated_at');
        $this->renameColumn($this->table, 'order', 'position');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
        $this->renameColumn($this->table, 'position', 'order');
    }
}
