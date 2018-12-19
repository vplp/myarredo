<?php

use yii\db\Migration;
//
use common\modules\catalog\Catalog;

class m181219_182143_update_catalog_sale_table extends Migration
{
    /**
     * table name
     * @var string
     */
    public $table = '{{%catalog_sale_item}}';

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
        $this->addColumn($this->table, 'mark', "enum('0','1') NOT NULL DEFAULT '0'");
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
