<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190226_172032_update_catalog_specification_italian_item_value_table extends Migration
{
    /**
     * @var string
     */
    public $tableRel = '{{%catalog_specification_italian_item_value}}';

    /**
     * @var string
     */
    public $tableSpecification = '{{%catalog_specification}}';

    /**
     * @var string
     */
    public $tableItalianItem = '{{%catalog_italian_item}}';


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
        $this->dropIndex('idx_specification_id_item_id', $this->tableRel);
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->createIndex('idx_specification_id_item_id', $this->tableRel, ['specification_id', 'item_id'], true);
    }
}
