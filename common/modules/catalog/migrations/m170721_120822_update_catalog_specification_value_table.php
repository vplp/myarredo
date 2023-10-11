<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_120822_update_catalog_specification_value_table
 */
class m170721_120822_update_catalog_specification_value_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%specification_value}}';

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
        $this->renameTable('specification_value', 'catalog_specification_value');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_specification_value', 'specification_value');
    }
}
