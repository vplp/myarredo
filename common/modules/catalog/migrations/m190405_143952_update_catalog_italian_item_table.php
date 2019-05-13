<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190405_143952_update_catalog_italian_item_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_italian_item}}';

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
        $this->addColumn($this->table, 'status', "enum('not_considered','not_approved','approved') NOT NULL DEFAULT 'not_considered'");
        $this->createIndex('status', $this->table, 'status');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('status', $this->table);
        $this->dropColumn($this->table, 'status');
    }
}
