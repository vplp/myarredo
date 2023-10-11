<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121322_update_catalog_factory_file_table
 */
class m170721_121422_update_catalog_factory_file_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%factory_file}}';

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
        $this->renameTable('factory_file', 'catalog_factory_file');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_factory_file', 'factory_file');
    }
}
