<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m170721_121122_update_catalog_specification_sale_value_table
 */
class m170721_121122_update_catalog_specification_sale_value_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%specification_sale_value}}';

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
        $this->renameTable('specification_sale_value', 'catalog_specification_sale_value');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->renameTable('catalog_specification_sale_value', 'specification_sale_value');
    }
}
