<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m191216_161424_update_catalog_product_table extends Migration
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
        $this->addColumn($this->table, 'mark2', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark2' AFTER mark1");
        $this->createIndex('mark2', $this->table, 'mark2');

        $this->addColumn($this->table, 'mark3', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark3' AFTER mark2");
        $this->createIndex('mark3', $this->table, 'mark3');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('mark3', $this->table);
        $this->dropColumn($this->table, 'mark3');

        $this->dropIndex('mark2', $this->table);
        $this->dropColumn($this->table, 'mark2');
    }
}
