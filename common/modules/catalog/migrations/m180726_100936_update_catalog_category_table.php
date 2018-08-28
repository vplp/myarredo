<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m180726_100936_update_catalog_category_table extends Migration
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
        $this->alterColumn($this->table, 'position', $this->integer(11)->unsigned()->defaultValue(0));

        $this->dropIndex('order', $this->table);

        $this->createIndex('position', $this->table, 'position');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {

    }
}
