<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170731_131922_update_catalog_sale_table
 */
class m170731_131922_update_catalog_sale_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%sale_catalog_item}}';

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

        $this->dropColumn($this->table, 'default_title');

        $this->renameTable('sale_catalog_item', 'catalog_sale_item');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_sale_item', 'sale_catalog_item');

        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('factory_id'));

        $this->renameColumn($this->table, 'position', 'order');
        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
    }
}
