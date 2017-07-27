<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121922_update_catalog_collection_table
 */
class m170721_131922_update_catalog_collection_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%collection}}';

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

        $this->dropColumn($this->table, 'default_title');

        $this->renameTable('collection', 'catalog_collection');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_collection', 'collection');

        $this->addColumn($this->table, 'default_title', $this->string(255)->defaultValue(null)->after('factory_id'));

        $this->renameColumn($this->table, 'published', 'enabled');
        $this->renameColumn($this->table, 'created_at', 'created');
        $this->renameColumn($this->table, 'updated_at', 'updated');
    }
}
