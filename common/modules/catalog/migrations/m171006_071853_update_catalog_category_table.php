<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

/**
 * Class m171006_071853_update_catalog_category_table
 */
class m171006_071853_update_catalog_category_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_group}}';

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
        $this->addColumn($this->table, 'product_count', $this->integer(1)->unsigned()->notNull()->defaultValue(0));
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'product_count');
    }
}
