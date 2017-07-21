<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121522_update_catalog_factory_filecatalog_many_catalog_table
 */
class m170721_121522_update_catalog_factory_filecatalog_many_catalog_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%factory_filecatalog_many_catalog}}';

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
        $this->renameTable('factory_filecatalog_many_catalog', 'catalog_factory_file_catalog_rel_catalog_item');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_factory_file_catalog_rel_catalog_item', 'factory_filecatalog_many_catalog');
    }
}
