<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m190911_145135_update_catalog_sale_phone_request_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item_phone_request}}';

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
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Mark'");
        $this->createIndex('mark', $this->table, 'mark');
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('mark', $this->table);
        $this->dropColumn($this->table, 'mark');
    }
}
